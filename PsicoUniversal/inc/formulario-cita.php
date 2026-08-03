<?php
/**
 * Procesa las solicitudes del formulario de citas.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'admin_post_nopriv_enviar_cita', 'alicia_procesar_formulario_cita' );
add_action( 'admin_post_enviar_cita', 'alicia_procesar_formulario_cita' );

function alicia_redirigir_formulario_cita( $argumentos ) {
    $destino_predeterminado = alicia_url_pagina( 'agenda-tu-cita' );
    $referente = wp_get_referer();
    $destino = wp_validate_redirect( $referente, $destino_predeterminado );

    wp_safe_redirect( add_query_arg( $argumentos, $destino ) );
    exit;
}

function alicia_procesar_formulario_cita() {
    if ( ! isset( $_POST['alicia_cita_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['alicia_cita_nonce'] ) ), 'alicia_enviar_cita' ) ) {
        wp_die( 'Verificacion de seguridad fallida. Regresa a la pagina anterior e intentalo de nuevo.' );
    }

    if ( ! empty( $_POST['sitio_web'] ) ) {
        alicia_redirigir_formulario_cita( array( 'cita' => 'exito' ) );
    }

    $nombre = isset( $_POST['nombre'] ) ? sanitize_text_field( wp_unslash( $_POST['nombre'] ) ) : '';
    $ciudad_pais = isset( $_POST['ciudad_pais'] ) ? sanitize_text_field( wp_unslash( $_POST['ciudad_pais'] ) ) : '';
    $correo = isset( $_POST['correo'] ) ? sanitize_email( wp_unslash( $_POST['correo'] ) ) : '';
    $whatsapp = isset( $_POST['whatsapp'] ) ? sanitize_text_field( wp_unslash( $_POST['whatsapp'] ) ) : '';
    $modalidad = isset( $_POST['modalidad'] ) ? sanitize_key( wp_unslash( $_POST['modalidad'] ) ) : '';
    $whatsapp_numerico = preg_replace( '/[^0-9]/', '', $whatsapp );

    $errores = array();
    if ( empty( $nombre ) ) {
        $errores[] = 'nombre';
    }
    if ( empty( $ciudad_pais ) ) {
        $errores[] = 'ciudad_pais';
    }
    if ( empty( $correo ) || ! is_email( $correo ) ) {
        $errores[] = 'correo';
    }
    if ( strlen( $whatsapp_numerico ) < 8 || strlen( $whatsapp_numerico ) > 15 ) {
        $errores[] = 'whatsapp';
    }
    if ( ! in_array( $modalidad, array( 'presencial', 'en_linea' ), true ) ) {
        $errores[] = 'modalidad';
    }

    $direccion_ip = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
    $clave_limite = 'alicia_cita_' . md5( $direccion_ip );

    if ( get_transient( $clave_limite ) ) {
        $errores[] = 'limite';
    }

    if ( ! empty( $errores ) ) {
        alicia_redirigir_formulario_cita( array( 'cita' => 'error' ) );
    }

    set_transient( $clave_limite, 1, MINUTE_IN_SECONDS );

    $post_id = wp_insert_post( array(
        'post_type' => 'cita',
        'post_title' => sprintf( '%1$s - %2$s', $nombre, current_time( 'd/m/Y H:i' ) ),
        'post_status' => 'private',
    ), true );

    if ( is_wp_error( $post_id ) ) {
        alicia_redirigir_formulario_cita( array( 'cita' => 'error' ) );
    }

    update_post_meta( $post_id, 'ciudad_pais', $ciudad_pais );
    update_post_meta( $post_id, 'correo', $correo );
    update_post_meta( $post_id, 'whatsapp', $whatsapp );
    update_post_meta( $post_id, 'modalidad', $modalidad );

    $modalidad_texto = ( 'presencial' === $modalidad ) ? 'Presencial' : 'En linea';
    $correo_alicia = alicia_campo( 'correo_contacto', alicia_opciones_sitio_id() );
    $correo_alicia = $correo_alicia ? $correo_alicia : get_option( 'admin_email' );
    $mensaje_whatsapp = sprintf(
        'Hola %s, gracias por agendar tu cita conmigo. Ya recibi tu solicitud y en breve te confirmo un horario disponible.',
        $nombre
    );
    $enlace_whatsapp = alicia_url_whatsapp( $whatsapp, $mensaje_whatsapp );
    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        sprintf( 'Reply-To: %1$s <%2$s>', sanitize_text_field( $nombre ), $correo ),
    );

    $boton_whatsapp = '';
    if ( $enlace_whatsapp ) {
        $boton_whatsapp = sprintf(
            '<p style="margin-top:24px;"><a href="%1$s" style="display:inline-block;background:#1677D2;color:#fff;padding:12px 24px;border-radius:8px;text-decoration:none;font-weight:bold;">Responder por WhatsApp</a></p>',
            esc_url( $enlace_whatsapp )
        );
    }

    $cuerpo_alicia = sprintf(
        '<div style="font-family:sans-serif;line-height:1.6;"><h2>Nueva solicitud de cita</h2><p><strong>Nombre:</strong> %1$s</p><p><strong>Ciudad / Pais:</strong> %2$s</p><p><strong>Correo:</strong> %3$s</p><p><strong>WhatsApp:</strong> %4$s</p><p><strong>Modalidad:</strong> %5$s</p>%6$s</div>',
        esc_html( $nombre ),
        esc_html( $ciudad_pais ),
        esc_html( $correo ),
        esc_html( $whatsapp ),
        esc_html( $modalidad_texto ),
        $boton_whatsapp
    );

    wp_mail( $correo_alicia, 'Nueva solicitud de cita - ' . $nombre, $cuerpo_alicia, $headers );

    $cuerpo_usuario = sprintf(
        '<div style="font-family:sans-serif;line-height:1.6;"><p>Hola %1$s,</p><p>Gracias por tu interes en agendar una cita (%2$s). Ya recibimos tu solicitud y pronto nos pondremos en contacto contigo por correo o WhatsApp para confirmar el horario.</p><p>Agradecemos mucho que te hayas contactado.</p><p>Con carino,<br>Alicia Monzalvo</p></div>',
        esc_html( $nombre ),
        esc_html( strtolower( $modalidad_texto ) )
    );

    wp_mail( $correo, 'Hemos recibido tu solicitud de cita', $cuerpo_usuario, array( 'Content-Type: text/html; charset=UTF-8' ) );

    alicia_redirigir_formulario_cita( array( 'cita' => 'exito' ) );
}
