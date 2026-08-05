<?php get_header(); ?>

<section class="pagina-header">
    <div class="pagina-header__card">
        <h1><?php the_title(); ?></h1>
        <?php
        while ( have_posts() ) : the_post();
            if ( get_the_content() ) :
                echo '<div class="pagina-header__intro">' . apply_filters( 'the_content', get_the_content() ) . '</div>';
            endif;
        endwhile;
        ?>

       
    </div>
</section>

<section class="cursos-lista">
    <div class="contenedor">

        <?php
        $cursos_query = new WP_Query( array(
            'post_type'      => 'curso',
            'posts_per_page' => -1,
            'orderby'        => 'menu_order title',
            'order'          => 'ASC',
        ) );
        ?>

        <?php if ( $cursos_query->have_posts() ) : ?>

            <div class="cursos-grid">
                <?php while ( $cursos_query->have_posts() ) : $cursos_query->the_post(); ?>

                    <?php
                    $estado         = get_field( 'estado_curso' );  // 'proximamente' | 'disponible'
                    $fecha_estimada = get_field( 'fecha_estimada' );
                    ?>

                    <article class="curso-card fade-in-al-scroll">

                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="curso-card__imagen">
                                <?php the_post_thumbnail( 'medium_large', array( 'loading' => 'lazy', 'alt' => get_the_title() ) ); ?>
                                <?php if ( $estado === 'proximamente' ) : ?>
                                    <span class="curso-card__etiqueta">Próximamente</span>
                                <?php endif; ?>
                            </div>
                        <?php elseif ( $estado === 'proximamente' ) : ?>
                            <div class="curso-card__imagen curso-card__imagen--placeholder">
                                <span class="curso-card__etiqueta">Próximamente</span>
                            </div>
                        <?php endif; ?>

                        <div class="curso-card__contenido">
                            <h2><?php the_title(); ?></h2>
                            <div class="curso-card__descripcion"><?php the_content(); ?></div>

                            <?php if ( $estado === 'proximamente' && $fecha_estimada ) : ?>
                                <p class="curso-card__fecha">Fecha estimada: <?php echo esc_html( $fecha_estimada ); ?></p>
                            <?php endif; ?>

                            <?php if ( $estado === 'disponible' ) : ?>
                                <a href="<?php echo esc_url( home_url( '/agenda-tu-cita' ) ); ?>" class="btn btn-secundario">Más información</a>
                            <?php endif; ?>
                        </div>

                    </article>

                <?php endwhile; ?>
            </div>
            <?php wp_reset_postdata(); ?>

        <?php else : ?>

            <!-- Estado vacío: aún no hay ningún curso cargado -->
            <div class="cursos-vacio fade-in-al-scroll">
                <h2>Coming soon…</h2>
                <p>Estamos preparando nuevos cursos para acompañarte en tu proceso. Muy pronto encontrarás aquí toda la información.</p>
                <p>Si quieres que te avisemos en cuanto estén disponibles, puedes <a href="<?php echo esc_url( home_url( '/agenda-tu-cita' ) ); ?>">dejarnos tus datos aquí</a>.</p>
            </div>

        <?php endif; ?>

    </div>
</section>

<?php get_footer(); ?>