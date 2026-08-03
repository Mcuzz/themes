<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link" href="#contenido-principal">Saltar al contenido principal</a>

<header class="sitio-header">
    <div class="contenedor sitio-header__contenido">
        <div class="logo">
            <?php if ( has_custom_logo() ) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
            <?php endif; ?>
        </div>

        <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="menu-principal">
            <span class="screen-reader-text">Abrir menu principal</span>
            <span class="menu-toggle__linea" aria-hidden="true"></span>
            <span class="menu-toggle__linea" aria-hidden="true"></span>
            <span class="menu-toggle__linea" aria-hidden="true"></span>
        </button>

        <nav id="menu-principal" class="nav-principal" aria-label="Navegacion principal">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'menu-principal',
                'container'      => false,
                'menu_class'     => 'menu-lista',
                'fallback_cb'    => 'alicia_menu_principal_respaldo',
            ) );
            ?>
        </nav>
    </div>
</header>

<main id="contenido-principal">
