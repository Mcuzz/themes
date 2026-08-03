<?php
/**
 * acf-options.php
 * Página de opciones globales del sitio (no es un post, es un panel único
 * donde Alicia edita el Hero, Contacto, Introducción, Galería y Redes).
 */

if ( ! defined( 'ABSPATH' ) ) exit;



if ( ! function_exists( 'acf_add_local_field_group' ) ) return;

acf_add_local_field_group( array(
    'key'    => 'group_opciones_inicio',
    'title'  => 'Opciones del Sitio',
    'fields' => array(

        /* ===== TAB: HERO ===== */
        array( 'key' => 'field_tab_hero', 'label' => 'Hero (encabezado)', 'type' => 'tab' ),
        array(
            'key'           => 'field_hero_foto',
            'label'         => 'Fotografía principal de Alicia',
            'name'          => 'hero_foto',
            'type'          => 'image',
            'return_format' => 'url',
            'preview_size'  => 'medium',
        ),
        array(
            'key'   => 'field_hero_frase_principal',
            'label' => 'Frase principal',
            'name'  => 'hero_frase_principal',
            'type'  => 'text',
        ),
        array(
            'key'   => 'field_hero_frase_secundaria',
            'label' => 'Frase secundaria (opcional)',
            'name'  => 'hero_frase_secundaria',
            'type'  => 'text',
        ),

        /* ===== TAB: CONTACTO ===== */
        array( 'key' => 'field_tab_contacto', 'label' => 'Contacto', 'type' => 'tab' ),
        array(
            'key'          => 'field_correo_contacto',
            'label'        => 'Correo de contacto (donde llegan las solicitudes de cita)',
            'name'         => 'correo_contacto',
            'type'         => 'email',
            'instructions' => 'A este correo llegará cada nueva solicitud del formulario de citas.',
        ),
        array(
            'key'   => 'field_nombre_profesional',
            'label' => 'Nombre profesional completo',
            'name'  => 'nombre_profesional_completo',
            'type'  => 'text',
        ),
        array(
            'key'          => 'field_titulo_profesional',
            'label'        => 'Título profesional',
            'name'         => 'titulo_profesional',
            'type'         => 'text',
            'instructions' => "Ej. 'Lic. en Psicología, Cédula Profesional 1234567'",
        ),
        array(
            'key'   => 'field_telefono_whatsapp',
            'label' => 'Teléfono / WhatsApp de contacto',
            'name'  => 'telefono_whatsapp',
            'type'  => 'text',
        ),
        array(
            'key'          => 'field_ciudad_estado',
            'label'        => 'Ciudad y Estado',
            'name'         => 'ciudad_estado',
            'type'         => 'text',
            'instructions' => 'Sin dirección exacta, solo ciudad y estado.',
        ),
        array(
            'key'   => 'field_horarios_atencion',
            'label' => 'Horarios de atención',
            'name'  => 'horarios_atencion',
            'type'  => 'textarea',
            'rows'  => 2,
        ),

        array(
    'key' => 'field_etiquetas_formacion',
    'label' => 'Formación complementaria y reconocimientos (etiquetas)',
    'name' => 'etiquetas_formacion',
    'type' => 'repeater',
    'instructions' => 'Diplomados sin fecha específica, cursos de formación continua, reconocimientos y afiliaciones. Se mostrarán como etiquetas agrupadas.',
    'layout' => 'table',
    'button_label' => 'Agregar etiqueta',
    'sub_fields' => array(
        array(
            'key' => 'field_etiqueta_texto',
            'label' => 'Texto',
            'name' => 'texto',
            'type' => 'text',
            'required' => 1,
        ),
        array(
            'key' => 'field_etiqueta_categoria',
            'label' => 'Categoría',
            'name' => 'categoria',
            'type' => 'select',
            'choices' => array(
                'diplomado' => 'Diplomado',
                'formacion_continua' => 'Formación continua',
                'reconocimiento' => 'Reconocimiento',
                'afiliacion' => 'Afiliación',
            ),
            'default_value' => 'diplomado',
        ),
    ),
),

        /* ===== TAB: INTRODUCCIÓN ===== */
        array( 'key' => 'field_tab_intro', 'label' => 'Introducción', 'type' => 'tab' ),
        array( 'key' => 'field_intro_quien_soy', 'label' => '¿Quién soy?', 'name' => 'intro_quien_soy', 'type' => 'wysiwyg' ),
        array( 'key' => 'field_intro_en_que_ayudo', 'label' => '¿En qué te puedo ayudar?', 'name' => 'intro_en_que_ayudo', 'type' => 'wysiwyg' ),
        array( 'key' => 'field_intro_enfoque', 'label' => '¿Cuál es mi enfoque?', 'name' => 'intro_enfoque', 'type' => 'wysiwyg' ),
        array( 'key' => 'field_intro_que_esperar', 'label' => '¿Qué puedes esperar al acudir conmigo?', 'name' => 'intro_que_esperar', 'type' => 'wysiwyg' ),
        array( 'key' => 'field_intro_compromiso', 'label' => 'Compromiso profesional, valores o filosofía', 'name' => 'intro_compromiso', 'type' => 'wysiwyg' ),

        /* ===== TAB: GALERÍA ===== */
        array( 'key' => 'field_tab_galeria', 'label' => 'Galería de Fotos', 'type' => 'tab' ),
        array( 'key' => 'field_galeria_1', 'label' => 'Foto 1', 'name' => 'galeria_foto_1', 'type' => 'image', 'return_format' => 'url' ),
        array( 'key' => 'field_galeria_2', 'label' => 'Foto 2', 'name' => 'galeria_foto_2', 'type' => 'image', 'return_format' => 'url' ),
        array( 'key' => 'field_galeria_3', 'label' => 'Foto 3', 'name' => 'galeria_foto_3', 'type' => 'image', 'return_format' => 'url' ),
        array( 'key' => 'field_galeria_4', 'label' => 'Foto 4', 'name' => 'galeria_foto_4', 'type' => 'image', 'return_format' => 'url' ),

        /* ===== TAB: REDES SOCIALES ===== */
        array( 'key' => 'field_tab_redes', 'label' => 'Redes Sociales', 'type' => 'tab' ),
        array( 'key' => 'field_url_facebook',  'label' => 'Facebook',  'name' => 'url_facebook',  'type' => 'url' ),
        array( 'key' => 'field_url_instagram', 'label' => 'Instagram', 'name' => 'url_instagram', 'type' => 'url' ),
        array( 'key' => 'field_url_youtube',   'label' => 'YouTube',   'name' => 'url_youtube',   'type' => 'url' ),
        array( 'key' => 'field_url_tiktok',    'label' => 'TikTok (si existe)',   'name' => 'url_tiktok',   'type' => 'url' ),
        array( 'key' => 'field_url_linkedin',  'label' => 'LinkedIn (si existe)', 'name' => 'url_linkedin', 'type' => 'url' ),

    ),
    'location' => array(
    array(
        array(
            'param'    => 'page',
            'operator' => '==',
            'value'    => alicia_opciones_sitio_id(),
        ),
    ),
),
) );