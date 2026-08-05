<?php get_header(); ?>

<?php
while ( have_posts() ) :
    the_post();
    $introduccion_pagina = get_the_content();
endwhile;
?>

<section class="pagina-header">
    <div class="pagina-header__card">

        <h1><?php the_title(); ?></h1>

        <?php if ( $introduccion_pagina ) : ?>
            <div class="pagina-header__intro">
                <?php echo apply_filters( 'the_content', $introduccion_pagina ); ?>
            </div>
        <?php endif; ?>

        <p class="pagina-intro__texto">
            Cada persona vive experiencias diferentes, por ello en
            <strong>PSICOUNIVERSAL</strong> ofrecemos procesos terapéuticos
            personalizados, basados en evidencia científica y adaptados a
            tus necesidades. Nuestro objetivo es brindarte herramientas para
            comprender lo que estás viviendo, fortalecer tus recursos
            personales y favorecer un bienestar duradero.
        </p>

        <div class="pagina-header__modalidades">

    <span class="pagina-header__modalidades-label">
        Modalidades
    </span>

    <span class="pagina-header__modalidades-items">
        Presencial &nbsp;&middot;&nbsp; En línea
    </span>

</div>

    </div>
</section>

<section class="terapias-lista">
    <div class="contenedor">
        <?php
        $terapias_query = new WP_Query( array(
            'post_type'      => 'terapia',
            'posts_per_page' => -1,
            'orderby'        => 'menu_order title',
            'order'          => 'ASC',
        ) );
        ?>

        <?php if ( $terapias_query->have_posts() ) : ?>
            <div class="terapias-grid">
    <?php $indice_terapia = 0; ?>
    <?php while ( $terapias_query->have_posts() ) : $terapias_query->the_post(); ?>
        <?php $indice_terapia++; ?>
        <article class="terapia-card fade-in-al-scroll" aria-labelledby="terapia-<?php the_ID(); ?>-titulo">

            <div class="terapia-card__imagen">
                <?php if ( has_post_thumbnail() ) : ?>
                    <?php
                    the_post_thumbnail(
                        'medium_large',
                        array(
                            'loading'  => 1 === $indice_terapia ? 'eager' : 'lazy',
                            'decoding' => 'async',
                            'sizes'    => '(min-width: 768px) 33vw, 100vw',
                            'alt'      => get_the_title(),
                        )
                    );
                    ?>
                <?php else : ?>
                    <div class="terapia-card__imagen-placeholder" aria-hidden="true">
                        <span>Psicouniversal</span>
                    </div>
                <?php endif; ?>
            </div>

            <div class="terapia-card__contenido">
                <h2 id="terapia-<?php the_ID(); ?>-titulo"><?php the_title(); ?></h2>
                <div class="terapia-card__descripcion">
                    <?php the_content(); ?>
                </div>

                <div class="terapia-card__cta">
                    <a href="<?php echo esc_url( alicia_url_pagina( 'agenda-tu-cita' ) ); ?>" class="btn btn--pequeno">
                        Agenda tu cita
                    </a>
                </div>
            </div>

        </article>
    <?php endwhile; ?>
</div>
            <?php wp_reset_postdata(); ?>
        <?php else : ?>
            <p class="terapias-vacio">
                Muy pronto encontraras aqui el detalle de cada terapia disponible.
                Mientras tanto, puedes <a href="<?php echo esc_url( alicia_url_pagina( 'agenda-tu-cita' ) ); ?>">agendar una cita</a>
                para platicar que necesitas.
            </p>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>

