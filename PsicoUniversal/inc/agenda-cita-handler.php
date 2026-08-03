<?php
if (!defined('ABSPATH')) exit;

function pu_procesar_solicitud_cita() {

    // URL de la página de agenda (para redirigir de vuelta)
    $url_agenda = wp_get_referer() ?: home_url('/agenda-tu-cita/');

    // ============================================
    // 1. Verificar nonce de seguridad
    // ============================================
    if (
        !isset($_POST['alicia_cita_nonce']) ||
        !wp_verify_nonce($_POST['alicia_cita_nonce'], 'alicia_enviar_cita')
    ) {
        wp_safe_redirect(add_query_arg('cita', 'error', $url_agenda));
        exit;
    }

    // ============================================
    // 2. Honeypot anti-spam
    // ============================================
    if (!empty($_POST['sitio_web'])) {
        // Fingimos éxito para no delatar al bot, pero no procesamos nada
        wp_safe_redirect(add_query_arg('cita', 'exito', $url_agenda));
        exit;
    }

    // ============================================
    // 3. Sanitizar entradas
    // ============================================
    $nombre       = sanitize_text_field($_POST['nombre'] ?? '');
    $ciudad_pais  = sanitize_text_field($_POST['ciudad_pais'] ?? '');
    $correo       = sanitize_email($_POST['correo'] ?? '');
    $whatsapp_raw = sanitize_text_field($_POST['whatsapp'] ?? '');
    $modalidad    = sanitize_key($_POST['modalidad'] ?? '');

    // ============================================
    // 4. Validación server-side
    // ============================================
    $modalidades_validas = array('presencial', 'en_linea');

    if (
        empty($nombre) ||
        empty($ciudad_pais) ||
        !is_email($correo) ||
        empty($whatsapp_raw) ||
        !in_array($modalidad, $modalidades_validas, true)
    ) {
        wp_safe_redirect(add_query_arg('cita', 'error', $url_agenda));
        exit;
    }

    // Limpiar número de WhatsApp: solo dígitos
    $whatsapp_limpio = preg_replace('/\D/', '', $whatsapp_raw);
    if (strlen($whatsapp_limpio) < 10) {
        wp_safe_redirect(add_query_arg('cita', 'error', $url_agenda));
        exit;
    }

    // Si viene sin código de país (10 dígitos = número local MX), anteponer 52
    $whatsapp_wa = (strlen($whatsapp_limpio) === 10)
        ? '52' . $whatsapp_limpio
        : $whatsapp_limpio;

    $modalidad_texto = ($modalidad === 'presencial') ? 'Presencial' : 'En línea';

    // ============================================
    // 5. Guardar como respaldo interno (CPT)
    // ============================================
    wp_insert_post(array(
        'post_type'   => 'solicitud_cita',
        'post_title'  => $nombre . ' - ' . current_time('d/m/Y H:i'),
        'post_status' => 'publish',
        'meta_input'  => array(
            'nombre'      => $nombre,
            'ciudad_pais' => $ciudad_pais,
            'correo'      => $correo,
            'whatsapp'    => $whatsapp_raw,
            'modalidad'   => $modalidad_texto,
        ),
    ));

    // ============================================
    // 6. Correo a Alicia (con botón de WhatsApp)
    // ============================================
    $admin_email = function_exists('get_field')
        ? (get_field('correo_contacto', 'option') ?: get_option('admin_email'))
        : get_option('admin_email');

    $mensaje_wa    = rawurlencode("Hola {$nombre}, soy Alicia Monzalvo. Recibí tu solicitud de cita ({$modalidad_texto}) y quiero confirmar los detalles contigo.");
    $link_whatsapp = "https://wa.me/{$whatsapp_wa}?text={$mensaje_wa}";

    $asunto_admin = "Nueva solicitud de cita: {$nombre}";
    $cuerpo_admin = "
        <div style='font-family: sans-serif; max-width: 500px; margin: 0 auto;'>
            <h2 style='color: #6B46C1;'>Nueva solicitud de cita</h2>
            <p><strong>Nombre:</strong> {$nombre}</p>
            <p><strong>Ciudad / País:</strong> {$ciudad_pais}</p>
            <p><strong>Correo:</strong> {$correo}</p>
            <p><strong>WhatsApp:</strong> {$whatsapp_raw}</p>
            <p><strong>Modalidad:</strong> {$modalidad_texto}</p>
            <div style='margin-top: 24px;'>
                <a href='{$link_whatsapp}' style='background-color: #25D366; color: #fff; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: bold; display: inline-block;'>
                    Contactar por WhatsApp
                </a>
            </div>
            <p style='margin-top: 20px; color: #888; font-size: 13px;'>Solicitud recibida el " . current_time('d/m/Y \a \l\a\s H:i') . "</p>
        </div>
    ";

    wp_mail($admin_email, $asunto_admin, $cuerpo_admin, array('Content-Type: text/html; charset=UTF-8'));

    // ============================================
    // 7. Correo de confirmación al usuario
    // ============================================
    $asunto_usuario = "Hemos recibido tu solicitud de cita";
    $cuerpo_usuario = pu_generar_email_confirmacion_usuario($nombre, $modalidad_texto);

    wp_mail($correo, $asunto_usuario, $cuerpo_usuario, array('Content-Type: text/html; charset=UTF-8'));

    // ============================================
    // 8. Redirigir con éxito
    // ============================================
    wp_safe_redirect(add_query_arg('cita', 'exito', $url_agenda));
    exit;
}
add_action('admin_post_enviar_cita', 'pu_procesar_solicitud_cita');
add_action('admin_post_nopriv_enviar_cita', 'pu_procesar_solicitud_cita');


// ============================================
// Plantilla del correo de confirmación al usuario
// ============================================
function pu_generar_email_confirmacion_usuario($nombre, $modalidad_texto) {
    return "
    <div style='font-family: sans-serif; max-width: 500px; margin: 0 auto; color: #333;'>
        <div style='background-color: #F3EEFB; padding: 24px; border-radius: 12px; text-align: center;'>
            <h1 style='color: #6B46C1; font-size: 22px; margin: 0;'>¡Gracias por escribirnos, {$nombre}!</h1>
        </div>
        <div style='padding: 24px 8px;'>
            <p>Hemos recibido tu solicitud de cita en modalidad <strong>{$modalidad_texto}</strong>.</p>
            <p>Alicia se pondrá en contacto contigo muy pronto, generalmente en menos de 24 a 48 horas hábiles, para confirmar horario y resolver cualquier duda que tengas.</p>
            <p>Mientras tanto, tómate un momento para respirar con calma. Diste un paso importante. 💜</p>
            <p style='margin-top: 24px;'>Con cariño,<br><strong>Alicia Monzalvo</strong><br>Psicóloga</p>
        </div>
    </div>
    ";
}