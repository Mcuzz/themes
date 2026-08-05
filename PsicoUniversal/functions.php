<?php
/**
 * functions.php
 * Configuración general del tema + registro de contenido personalizado
 */

// Seguridad: evita acceso directo al archivo
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * La versión gratuita de ACF no incluye "Options Page" (eso es de ACF PRO).
 * En su lugar, usamos una Página normal de WordPress con slug 'opciones-sitio'
 * como si fuera el panel de opciones. Esta función encuentra su ID automáticamente,
 * para no tener que escribir el número a mano en ningún lado.
 */

// ============================================
// CPT: Solicitud de Cita (respaldo interno)
// ============================================
function pu_registrar_cpt_solicitud_cita() {
    register_post_type('solicitud_cita', array(
        'labels' => array(
            'name'          => 'Solicitudes de Cita',
            'singular_name' => 'Solicitud de Cita',
        ),
        'public'       => false,
        'show_ui'      => true,
        'show_in_menu' => true,
        'menu_icon'    => 'dashicons-calendar-alt',
        'has_archive'  => false,
        'supports'     => array('title'),
        'capability_type' => 'post',
    ));
}
add_action('init', 'pu_registrar_cpt_solicitud_cita');

// Cargar el handler del formulario de citas
require_once get_template_directory() . '/inc/agenda-cita-handler.php';

function alicia_opciones_sitio_id() {
    static $id = null;
    if ( $id === null ) {
        $pagina = get_page_by_path( 'opciones-sitio' );
        $id = $pagina ? $pagina->ID : 0;
    }
    return $id;
}

function alicia_campo( $campo, $post_id = false ) {
    if ( ! function_exists( 'get_field' ) ) {
        return false;
    }

    return $post_id ? get_field( $campo, $post_id ) : get_field( $campo );
}

function alicia_url_pagina( $slug ) {
    $pagina = get_page_by_path( $slug );

    return $pagina ? get_permalink( $pagina ) : home_url( '/' . trim( $slug, '/' ) . '/' );
}

function alicia_url_whatsapp( $telefono, $mensaje = '' ) {
    $telefono = preg_replace( '/[^0-9]/', '', (string) $telefono );

    if ( strlen( $telefono ) < 8 ) {
        return '';
    }

    $url = 'https://wa.me/' . $telefono;

    return $mensaje ? $url . '?text=' . rawurlencode( $mensaje ) : $url;
}

function alicia_version_recurso( $ruta_relativa ) {
    $archivo = get_template_directory() . $ruta_relativa;

    return file_exists( $archivo ) ? (string) filemtime( $archivo ) : wp_get_theme()->get( 'Version' );
}

function alicia_menu_principal_respaldo() {
    $paginas = array(
        'Inicio'          => '',
        'Terapias'        => 'terapias',
        'Cursos'          => 'cursos',
        'Espacio Violeta' => 'espacio-violeta',
        'Sobre mi'        => 'sobre-mi',
        'Agenda tu cita'  => 'agenda-tu-cita',
    );

    echo '<ul class="menu-lista">';
    foreach ( $paginas as $etiqueta => $slug ) {
        $url = $slug ? alicia_url_pagina( $slug ) : home_url( '/' );
        printf( '<li><a href="%1$s">%2$s</a></li>', esc_url( $url ), esc_html( $etiqueta ) );
    }
    echo '</ul>';
}

// Carga los campos de ACF definidos por código (no requiere usar el panel de ACF)
require_once get_template_directory() . '/inc/acf-fields.php';
require_once get_template_directory() . '/inc/acf-options.php';
require_once get_template_directory() . '/inc/formulario-cita.php';

/* ============================================
   1. CONFIGURACIÓN BÁSICA DEL TEMA
   ============================================ */
function alicia_theme_setup() {
    // Permite título editable, imagen destacada, menús, etc.
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' ); // fotos destacadas
    add_theme_support( 'custom-logo', array(
        'height'      => 100,
        'width'       => 360,
        'flex-height' => true,
        'flex-width'  => true,
    ) );
    add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption' ) );
    add_theme_support( 'responsive-embeds' ); // videos de YouTube responsivos

    // Menú de navegación principal (lo asignaremos desde el panel de WP)
    register_nav_menus( array(
        'menu-principal' => __( 'Menú Principal', 'alicia-monzalvo' ),
    ) );
}
add_action( 'after_setup_theme', 'alicia_theme_setup' );

/* ============================================
   2. CARGA DE ESTILOS Y SCRIPTS (enqueue)
   ============================================ */
function alicia_theme_assets() {
    // style.css principal (el de cabecera obligatoria)
    wp_enqueue_style( 'alicia-style', get_stylesheet_uri(), array(), alicia_version_recurso( '/style.css' ) );

    // Nuestro CSS real, organizado
    wp_enqueue_style( 'alicia-main', get_template_directory_uri() . '/assets/css/main.css', array( 'alicia-style' ), alicia_version_recurso( '/assets/css/main.css' ) );

    // Nuestro JS (defer para no bloquear la carga = más calmado/ligero)
    wp_enqueue_script( 'alicia-main-js', get_template_directory_uri() . '/assets/js/main.js', array(), alicia_version_recurso( '/assets/js/main.js' ), true );
}
add_action( 'wp_enqueue_scripts', 'alicia_theme_assets' );

/* ============================================
   3. CUSTOM POST TYPES
   Cada uno es un "molde" de contenido que Alicia
   podrá llenar desde el panel de WordPress.
   ============================================ */

function alicia_registrar_cpts() {

register_post_type( 'cita', array(
    'labels' => array(
        'name'          => 'Citas Recibidas',
        'singular_name' => 'Cita',
    ),
    'public'          => false,
    'show_ui'         => true,
    'show_in_menu'    => true,
    'menu_icon'       => 'dashicons-calendar-alt',
    'supports'        => array( 'title' ),
    'has_archive'     => false,
    'rewrite'         => false,
    'capability_type' => 'post',
) );

    // --- TERAPIAS ---
    register_post_type( 'terapia', array(
        'labels' => array(
            'name' => 'Terapias',
            'singular_name' => 'Terapia',
            'add_new_item' => 'Agregar nueva terapia',
        ),
        'public' => true,
        'has_archive' => false,
        'menu_icon' => 'dashicons-heart',
        'supports' => array( 'title', 'editor', 'thumbnail' ),
        'rewrite' => array( 'slug' => 'terapias' ),
        'show_in_rest' => true, // habilita editor de bloques + compatibilidad con ACF
    ) );

    // --- TESTIMONIOS ---
    register_post_type( 'testimonio', array(
        'labels' => array(
            'name' => 'Testimonios',
            'singular_name' => 'Testimonio',
            'add_new_item' => 'Agregar nuevo testimonio',
        ),
        'public' => true,
        'has_archive' => false,
        'menu_icon' => 'dashicons-format-quote',
        'supports' => array( 'title', 'editor' ),
        'show_in_rest' => true,
    ) );

    // --- EVENTOS ESPACIO VIOLETA ---
    register_post_type( 'evento_violeta', array(
        'labels' => array(
            'name' => 'Eventos Espacio Violeta',
            'singular_name' => 'Evento',
            'add_new_item' => 'Agregar nuevo evento',
        ),
        'public' => true,
        'has_archive' => false,
        'menu_icon' => 'dashicons-calendar-alt',
        'supports' => array( 'title', 'editor', 'thumbnail' ),
        'rewrite' => array( 'slug' => 'espacio-violeta' ),
        'show_in_rest' => true,
    ) );

    // --- PUBLICACIONES (libros) ---
    register_post_type( 'publicacion', array(
        'labels' => array(
            'name' => 'Publicaciones',
            'singular_name' => 'Publicación',
            'add_new_item' => 'Agregar nueva publicación',
        ),
        'public' => true,
        'has_archive' => false,
        'menu_icon' => 'dashicons-book',
        'supports' => array( 'title', 'editor', 'thumbnail' ),
        'show_in_rest' => true,
    ) );

    // --- PODCAST / YOUTUBE ---
    register_post_type( 'podcast_episodio', array(
        'labels' => array(
            'name' => 'Podcast',
            'singular_name' => 'Episodio',
            'add_new_item' => 'Agregar nuevo episodio',
        ),
        'public' => true,
        'has_archive' => false,
        'menu_icon' => 'dashicons-microphone',
        'supports' => array( 'title', 'editor', 'thumbnail' ),
        'show_in_rest' => true,
    ) );

    // --- INVESTIGACIONES ---
    register_post_type( 'investigacion', array(
        'labels' => array(
            'name' => 'Investigaciones',
            'singular_name' => 'Investigación',
            'add_new_item' => 'Agregar nueva investigación',
        ),
        'public' => true,
        'has_archive' => false,
        'menu_icon' => 'dashicons-media-document',
        'supports' => array( 'title', 'editor' ),
        'show_in_rest' => true,
    ) );

    // --- CURSOS (Coming soon) ---
    register_post_type( 'curso', array(
        'labels' => array(
            'name' => 'Cursos',
            'singular_name' => 'Curso',
            'add_new_item' => 'Agregar nuevo curso',
        ),
        'public' => true,
        'has_archive' => false,
        'menu_icon' => 'dashicons-welcome-learn-more',
        'supports' => array( 'title', 'editor', 'thumbnail' ),
        'rewrite' => array( 'slug' => 'cursos' ),
        'show_in_rest' => true,
    ) );

// --- FORMACIÓN ACADÉMICA ---
// No necesita página propia ni archivo público: solo se usa
// internamente para listar en "Sobre mí". Por eso 'public' => false.
register_post_type( 'formacion_academica', array(
    'labels' => array(
        'name' => 'Formación Académica',
        'singular_name' => 'Formación',
        'add_new_item' => 'Agregar formación / diplomado',
    ),
    'public'       => false,
    'show_ui'      => true,
    'show_in_menu' => true,
    'menu_icon'    => 'dashicons-welcome-learn-more',
    'supports'     => array( 'title' ),
    'has_archive'  => false,
    'rewrite'      => false,
    'show_in_rest' => true,
) );

// --- EXPERIENCIA PROFESIONAL ---
register_post_type( 'experiencia_profesional', array(
    'labels' => array(
        'name' => 'Experiencia Profesional',
        'singular_name' => 'Experiencia',
        'add_new_item' => 'Agregar experiencia profesional',
    ),
    'public'       => false,
    'show_ui'      => true,
    'show_in_menu' => true,
    'menu_icon'    => 'dashicons-businessman',
    'supports'     => array( 'title' ),
    'has_archive'  => false,
    'rewrite'      => false,
    'show_in_rest' => true,
) );
}
add_action( 'init', 'alicia_registrar_cpts' );

/* ============================================
   4. AJUSTES DE SEGURIDAD Y RENDIMIENTO BÁSICOS
   ============================================ */
remove_action( 'wp_head', 'wp_generator' ); // oculta versión de WP (seguridad)

/* ============================================
   5. NOTA: Los campos personalizados de cada CPT
   (ej. "Fecha del evento", "Precio", "Ciudad del
   testimonio") los crearemos con ACF en el
   siguiente paso, usando "Grupos de campos" desde
   el panel — no requieren código adicional aquí.
   ============================================ */

   function alicia_icono_red( $nombre_red ) {
    $iconos = array(
        'Facebook' => '<svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M22 12a10 10 0 1 0-11.5 9.9v-7H7.9V12h2.6V9.8c0-2.6 1.5-4 3.9-4 1.1 0 2.3.2 2.3.2v2.5h-1.3c-1.3 0-1.7.8-1.7 1.6V12h2.9l-.5 2.9h-2.4v7A10 10 0 0 0 22 12Z"/></svg>',
        'Instagram' => '<svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M12 2c2.7 0 3.1 0 4.1.1 1.1 0 1.8.2 2.5.5.7.3 1.2.6 1.8 1.2.6.6.9 1.1 1.2 1.8.3.7.5 1.4.5 2.5.1 1 .1 1.4.1 4.1s0 3.1-.1 4.1c0 1.1-.2 1.8-.5 2.5-.3.7-.6 1.2-1.2 1.8-.6.6-1.1.9-1.8 1.2-.7.3-1.4.5-2.5.5-1 .1-1.4.1-4.1.1s-3.1 0-4.1-.1c-1.1 0-1.8-.2-2.5-.5-.7-.3-1.2-.6-1.8-1.2-.6-.6-.9-1.1-1.2-1.8-.3-.7-.5-1.4-.5-2.5C2 15.1 2 14.7 2 12s0-3.1.1-4.1c0-1.1.2-1.8.5-2.5.3-.7.6-1.2 1.2-1.8.6-.6 1.1-.9 1.8-1.2.7-.3 1.4-.5 2.5-.5C8.9 2 9.3 2 12 2Zm0 2c-2.7 0-3 0-4 .1-.8 0-1.3.2-1.6.3-.4.2-.7.3-1 .6-.3.3-.5.6-.6 1-.1.3-.3.8-.3 1.6C4.4 9 4.4 9.3 4.4 12s0 3 .1 4c0 .8.2 1.3.3 1.6.2.4.3.7.6 1 .3.3.6.5 1 .6.3.1.8.3 1.6.3 1 .1 1.3.1 4 .1s3 0 4-.1c.8 0 1.3-.2 1.6-.3.4-.2.7-.3 1-.6.3-.3.5-.6.6-1 .1-.3.3-.8.3-1.6.1-1 .1-1.3.1-4s0-3-.1-4c0-.8-.2-1.3-.3-1.6-.2-.4-.3-.7-.6-1-.3-.3-.6-.5-1-.6-.3-.1-.8-.3-1.6-.3-1-.1-1.3-.1-4-.1Zm0 3.4a4.6 4.6 0 1 1 0 9.2 4.6 4.6 0 0 1 0-9.2Zm0 2a2.6 2.6 0 1 0 0 5.2 2.6 2.6 0 0 0 0-5.2Zm4.8-2.6a1.1 1.1 0 1 1 0 2.1 1.1 1.1 0 0 1 0-2.1Z"/></svg>',
        'YouTube' => '<svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M21.6 7.2s-.2-1.5-.8-2.1c-.8-.8-1.7-.8-2.1-.9C15.9 4 12 4 12 4s-3.9 0-6.7.2c-.4 0-1.3.1-2.1.9-.6.6-.8 2.1-.8 2.1S2.2 9 2.2 10.8v1.4c0 1.8.2 3.6.2 3.6s.2 1.5.8 2.1c.8.8 1.9.8 2.3.9 1.7.1 7 .2 7 .2s3.9 0 6.7-.2c.4 0 1.3-.1 2.1-.9.6-.6.8-2.1.8-2.1s.2-1.8.2-3.6v-1.4c0-1.8-.2-3.6-.2-3.6ZM9.9 14.6V8.6l5.6 3-5.6 3Z"/></svg>',
        'TikTok' => '<svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M16.6 2h-3.2v13.4a2.6 2.6 0 1 1-1.8-2.5v-3.3a5.9 5.9 0 1 0 5 5.8V8.9a7.6 7.6 0 0 0 4.4 1.4V7.1a4.4 4.4 0 0 1-4.4-4.4V2Z"/></svg>',
        'LinkedIn' => '<svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M6.9 8.4H3.6V20h3.3V8.4ZM5.3 3.6a1.9 1.9 0 1 0 0 3.8 1.9 1.9 0 0 0 0-3.8ZM20.4 20h-3.3v-6.1c0-1.5 0-3.4-2.1-3.4-2 0-2.4 1.6-2.4 3.3V20H9.3V8.4h3.2v1.6h.1c.4-.8 1.5-1.7 3.1-1.7 3.3 0 3.9 2.2 3.9 5V20Z"/></svg>',
    );
 
    if ( isset( $iconos[ $nombre_red ] ) ) {
        echo $iconos[ $nombre_red ]; // phpcs:ignore -- SVG controlado por nosotros, no input de usuario
    }
}

/* ============================================
   GRID DE ETIQUETAS
   Helper reutilizable para mostrar listas cortas
   (características, modalidades, áreas de atención,
   enfoques, líneas de investigación, etc.) como
   etiquetas en vez de párrafos o bullets largos.
   Reduce carga cognitiva para lectores con ansiedad.

   Uso:
   alicia_grid_etiquetas( array( 'Ansiedad', 'Depresión', 'Estrés' ) );
   ============================================ */
function alicia_grid_etiquetas( $items ) {
    if ( empty( $items ) ) {
        return;
    }
    echo '<div class="grid-etiquetas fade-in-al-scroll">';
    foreach ( $items as $texto ) {
        echo '<span class="etiqueta">' . esc_html( $texto ) . '</span>';
    }
    echo '</div>';
}