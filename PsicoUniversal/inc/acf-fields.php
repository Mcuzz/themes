<?php
/**
 * acf-fields.php
 * Todos los grupos de campos ACF registrados por código.
 * No requiere usar la interfaz de administración de ACF en absoluto.
 * Para editar campos: edita este archivo. Para agregar un campo nuevo:
 * copia un bloque `array(...)` dentro de 'fields' y ajústalo.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! function_exists( 'acf_add_local_field_group' ) ) return;

/* ============================================
   1. TESTIMONIO
   ============================================ */
acf_add_local_field_group( array(
    'key'    => 'group_testimonio',
    'title'  => 'Detalles del Testimonio',
    'fields' => array(
        array(
            'key'          => 'field_test_ciudad_pais',
            'label'        => 'Ciudad / País',
            'name'         => 'ciudad_pais',
            'type'         => 'text',
            'instructions' => 'Ej. Guatemala, Ciudad de Guatemala',
        ),
    ),
    'location' => array(
        array(
            array(
                'param'    => 'post_type',
                'operator' => '==',
                'value'    => 'testimonio',
            ),
        ),
    ),
) );

/* ============================================
   2. EVENTO ESPACIO VIOLETA
   ============================================ */
acf_add_local_field_group( array(
    'key'    => 'group_evento_violeta',
    'title'  => 'Detalles del Evento (Espacio Violeta)',
    'fields' => array(
        array(
            'key'          => 'field_ev_objetivo',
            'label'        => 'Objetivo del evento',
            'name'         => 'objetivo',
            'type'         => 'textarea',
            'instructions' => '¿Qué busca lograr este evento en los participantes?',
            'rows'         => 3,
        ),
        array(
            'key'            => 'field_ev_fecha',
            'label'          => 'Fecha del evento',
            'name'           => 'fecha_evento',
            'type'           => 'date_picker',
            'required'       => 1,
            'display_format' => 'd/m/Y',
            'return_format'  => 'd/m/Y',
        ),
        array(
            'key'            => 'field_ev_hora',
            'label'          => 'Hora del evento',
            'name'           => 'hora_evento',
            'type'           => 'time_picker',
            'display_format' => 'g:i a',
            'return_format'  => 'g:i a',
        ),
        array(
            'key'          => 'field_ev_duracion',
            'label'        => 'Duración',
            'name'         => 'duracion',
            'type'         => 'text',
            'instructions' => 'Ej. 2 horas, todo el día',
        ),
        array(
            'key'           => 'field_ev_modalidad',
            'label'         => 'Modalidad',
            'name'          => 'modalidad',
            'type'          => 'select',
            'required'      => 1,
            'choices'       => array(
                'en_linea'   => 'En línea',
                'presencial' => 'Presencial',
            ),
            'default_value' => 'presencial',
            'ui'            => 1,
        ),
        array(
            'key'               => 'field_ev_direccion',
            'label'             => 'Dirección (si aplica)',
            'name'              => 'direccion',
            'type'              => 'text',
            'instructions'      => 'Solo si es presencial. Evitar dirección exacta si se prefiere privacidad.',
            'conditional_logic' => array(
                array(
                    array(
                        'field'    => 'field_ev_modalidad',
                        'operator' => '==',
                        'value'    => 'presencial',
                    ),
                ),
            ),
        ),
        array(
            'key'          => 'field_ev_precio',
            'label'        => 'Precio',
            'name'         => 'precio',
            'type'         => 'text',
            'instructions' => 'Ej. $500 MXN, Gratuito, Aportación voluntaria',
        ),
        array(
            'key'   => 'field_ev_metodos_pago',
            'label' => 'Métodos de pago',
            'name'  => 'metodos_pago',
            'type'  => 'textarea',
            'rows'  => 2,
        ),
        array(
            'key'   => 'field_ev_cupo',
            'label' => 'Cupo',
            'name'  => 'cupo',
            'type'  => 'number',
        ),
        array(
            'key'   => 'field_ev_requisitos',
            'label' => 'Requisitos',
            'name'  => 'requisitos',
            'type'  => 'textarea',
            'rows'  => 2,
        ),
        array(
            'key'          => 'field_ev_publico_objetivo',
            'label'        => 'Público objetivo',
            'name'         => 'publico_objetivo',
            'type'         => 'textarea',
            'instructions' => '¿Para quién es este evento?',
            'rows'         => 2,
        ),
        array(
            'key'          => 'field_ev_medio_contacto',
            'label'        => 'Medio de contacto para inscripción/pago',
            'name'         => 'medio_contacto',
            'type'         => 'text',
            'instructions' => 'Ej. WhatsApp, correo, link de pago',
        ),
    ),
    'location' => array(
        array(
            array(
                'param'    => 'post_type',
                'operator' => '==',
                'value'    => 'evento_violeta',
            ),
        ),
    ),
) );

/* ============================================
   3. PUBLICACIÓN (LIBRO)
   ============================================ */
acf_add_local_field_group( array(
    'key'    => 'group_publicacion',
    'title'  => 'Detalles de la Publicación (Libro)',
    'fields' => array(
        array(
            'key'   => 'field_pub_anio',
            'label' => 'Año de publicación',
            'name'  => 'anio_publicacion',
            'type'  => 'number',
        ),
        array(
            'key'          => 'field_pub_editorial',
            'label'        => 'Editorial',
            'name'         => 'editorial',
            'type'         => 'text',
            'instructions' => 'Si aplica',
        ),
        array(
            'key'          => 'field_pub_enlace',
            'label'        => 'Enlace para compra',
            'name'         => 'enlace_compra',
            'type'         => 'url',
            'instructions' => 'Si existe',
        ),
    ),
    'location' => array(
        array(
            array(
                'param'    => 'post_type',
                'operator' => '==',
                'value'    => 'publicacion',
            ),
        ),
    ),
) );

/* ============================================
   4. PODCAST / YOUTUBE
   ============================================ */
acf_add_local_field_group( array(
    'key'    => 'group_podcast',
    'title'  => 'Detalles del Episodio (Podcast/YouTube)',
    'fields' => array(
        array(
            'key'          => 'field_pod_enlace',
            'label'        => 'Enlace de YouTube',
            'name'         => 'enlace_youtube',
            'type'         => 'url',
            'required'     => 1,
            'instructions' => 'URL completa del video',
        ),
    ),
    'location' => array(
        array(
            array(
                'param'    => 'post_type',
                'operator' => '==',
                'value'    => 'podcast_episodio',
            ),
        ),
    ),
) );

/* ============================================
   5. INVESTIGACIÓN
   ============================================ */
acf_add_local_field_group( array(
    'key'    => 'group_investigacion',
    'title'  => 'Detalles de la Investigación',
    'fields' => array(
        array(
            'key'   => 'field_inv_anio',
            'label' => 'Año',
            'name'  => 'anio',
            'type'  => 'number',
        ),
        array(
            'key'          => 'field_inv_enlace',
            'label'        => 'Enlace al documento',
            'name'         => 'enlace_documento',
            'type'         => 'url',
            'instructions' => 'Si existe una versión pública',
        ),
    ),
    'location' => array(
        array(
            array(
                'param'    => 'post_type',
                'operator' => '==',
                'value'    => 'investigacion',
            ),
        ),
    ),
) );

/* ============================================
   6. CURSO
   ============================================ */
acf_add_local_field_group( array(
    'key'    => 'group_curso',
    'title'  => 'Detalles del Curso',
    'fields' => array(
        array(
            'key'           => 'field_curso_estado',
            'label'         => 'Estado',
            'name'          => 'estado_curso',
            'type'          => 'select',
            'required'      => 1,
            'choices'       => array(
                'proximamente' => 'Próximamente',
                'disponible'   => 'Disponible',
            ),
            'default_value' => 'proximamente',
            'ui'            => 1,
        ),
        array(
            'key'          => 'field_curso_fecha_estimada',
            'label'        => 'Fecha estimada de lanzamiento',
            'name'         => 'fecha_estimada',
            'type'         => 'text',
            'instructions' => "Opcional. Ej. 'Otoño 2026' o dejar vacío",
        ),
    ),
    'location' => array(
        array(
            array(
                'param'    => 'post_type',
                'operator' => '==',
                'value'    => 'curso',
            ),
        ),
    ),
) );
/* ============================================
   7. FORMACIÓN ACADÉMICA
   El "Título" del post es la Carrera o Diplomado.
   ============================================ */
acf_add_local_field_group(array(
    'key' => 'group_formacion_academica',
    'title' => 'Detalles de Formación Académica',
    'fields' => array(
        array(
            'key' => 'field_fa_institucion',
            'label' => 'Institución',
            'name' => 'institucion',
            'type' => 'text',
            'instructions' => 'Déjalo vacío si no aplica o no se especificó.',
            'required' => 0, // antes estaba en 1
        ),
        array(
            'key' => 'field_fa_anio',
            'label' => 'Año de conclusión',
            'name' => 'anio_conclusion',
            'type' => 'text', // texto en vez de number: permite "En curso", "2019-2021", etc.
            'instructions' => 'Puede quedar vacío, o usar "En curso" si aplica.',
            'required' => 0,
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'formacion_academica',
            ),
        ),
    ),
));

/* ============================================
   8. EXPERIENCIA PROFESIONAL
   El "Título" del post es el lugar de trabajo.
   ============================================ */
acf_add_local_field_group( array(
    'key'    => 'group_experiencia',
    'title'  => 'Detalles de la Experiencia',
    'fields' => array(
        array(
            'key'          => 'field_exp_periodo',
            'label'        => 'Periodo',
            'name'         => 'periodo',
            'type'         => 'text',
            'instructions' => "Ej. '2018 – 2022' o '2020 – Presente'",
        ),
        array(
            'key'   => 'field_exp_especialidades',
            'label' => 'Especialidades',
            'name'  => 'especialidades',
            'type'  => 'textarea',
            'rows'  => 2,
        ),
        array(
            'key'   => 'field_exp_logros',
            'label' => 'Logros destacados',
            'name'  => 'logros',
            'type'  => 'textarea',
            'rows'  => 2,
        ),
    ),
    'location' => array(
        array(
            array(
                'param'    => 'post_type',
                'operator' => '==',
                'value'    => 'experiencia_profesional',
            ),
        ),
    ),
    
) );

acf_add_local_field_group( array(
    'key'    => 'group_cita',
    'title'  => 'Datos de la Solicitud',
    'fields' => array(
        array( 'key' => 'field_cita_ciudad_pais', 'label' => 'Ciudad / País', 'name' => 'ciudad_pais', 'type' => 'text' ),
        array( 'key' => 'field_cita_correo',      'label' => 'Correo electrónico', 'name' => 'correo', 'type' => 'email' ),
        array( 'key' => 'field_cita_whatsapp',    'label' => 'WhatsApp', 'name' => 'whatsapp', 'type' => 'text' ),
        array(
            'key'     => 'field_cita_modalidad',
            'label'   => 'Modalidad',
            'name'    => 'modalidad',
            'type'    => 'select',
            'choices' => array(
                'presencial' => 'Presencial',
                'en_linea'   => 'En línea',
            ),
            'ui' => 1,
        ),
    ),
    'location' => array(
        array(
            array( 'param' => 'post_type', 'operator' => '==', 'value' => 'cita' ),
        ),
    ),
) );