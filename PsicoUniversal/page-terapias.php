<?php get_header(); ?>

<?php
while ( have_posts() ) :
    the_post();
    $introduccion_pagina = get_the_content();
endwhile;
?>

<section class="pagina-header">
    <div class="contenedor">
        <h1><?php the_title(); ?></h1>
        <?php if ( $introduccion_pagina ) : ?>
            <div class="pagina-header__intro"><?php echo apply_filters( 'the_content', $introduccion_pagina ); ?></div>
        <?php endif; ?>
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
            <div class="terapias-editorial">
                <?php $indice_terapia = 0; ?>
                <?php while ( $terapias_query->have_posts() ) : $terapias_query->the_post(); ?>
                    <?php $indice_terapia++; ?>
                    <article class="terapia fade-in-al-scroll" aria-labelledby="terapia-<?php the_ID(); ?>-titulo">
                        <div class="terapia__texto">
                            
                            <h2 id="terapia-<?php the_ID(); ?>-titulo"><?php the_title(); ?></h2>
                            <div class="terapia__descripcion">
                                <?php the_content(); ?>
                            </div>
                            <a href="<?php echo esc_url( alicia_url_pagina( 'agenda-tu-cita' ) ); ?>" class="terapia__enlace">
                                Agenda una consulta <span aria-hidden="true">&rarr;</span>
                            </a>
                        </div>

                        <div class="terapia__imagen">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <?php
                                the_post_thumbnail(
                                    'medium_large',
                                    array(
                                        'loading'  => 1 === $indice_terapia ? 'eager' : 'lazy',
                                        'decoding' => 'async',
                                        'sizes'    => '(min-width: 768px) 50vw, 100vw',
                                        'alt'      => get_the_title(),
                                    )
                                );
                                ?>
                            <?php else : ?>
                                <div class="terapia__imagen-placeholder" aria-hidden="true">
                                    <span>Psicouniversal</span>
                                </div>
                            <?php endif; ?>
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
