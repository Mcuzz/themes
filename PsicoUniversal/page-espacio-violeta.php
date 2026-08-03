<?php get_header(); ?>

<section class="pagina-header pagina-header--violeta">
    <div class="contenedor">
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

<section class="eventos-lista">
    <div class="contenedor">

        <?php
        $eventos_query = new WP_Query( array(
            'post_type'      => 'evento_violeta',
            'posts_per_page' => -1,
            'orderby'        => 'menu_order title',
            'order'          => 'ASC',
        ) );
        ?>

        <?php if ( $eventos_query->have_posts() ) : ?>

            <?php while ( $eventos_query->have_posts() ) : $eventos_query->the_post(); ?>

                <?php
                $objetivo         = get_field( 'objetivo' );
                $fecha            = get_field( 'fecha_evento' );
                $hora             = get_field( 'hora_evento' );
                $duracion         = get_field( 'duracion' );
                $modalidad        = get_field( 'modalidad' );        // 'en_linea' | 'presencial'
                $direccion        = get_field( 'direccion' );
                $precio           = get_field( 'precio' );
                $metodos_pago     = get_field( 'metodos_pago' );
                $cupo             = get_field( 'cupo' );
                $requisitos       = get_field( 'requisitos' );
                $publico_objetivo = get_field( 'publico_objetivo' );
                $medio_contacto   = get_field( 'medio_contacto' );

                $modalidad_texto = ( $modalidad === 'en_linea' ) ? 'En línea' : 'Presencial';
                ?>

                <article class="evento-item fade-in-al-scroll">

                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="evento-item__imagen">
                            <?php the_post_thumbnail( 'medium_large', array( 'loading' => 'lazy', 'alt' => get_the_title() ) ); ?>
                        </div>
                    <?php endif; ?>

                    <div class="evento-item__contenido">

                        <span class="evento-item__modalidad evento-item__modalidad--<?php echo esc_attr( $modalidad ); ?>">
                            <?php echo esc_html( $modalidad_texto ); ?>
                        </span>

                        <h2><?php the_title(); ?></h2>

                        <div class="evento-item__descripcion"><?php the_content(); ?></div>

                        <?php if ( $objetivo ) : ?>
                            <p class="evento-item__objetivo"><strong>Objetivo:</strong> <?php echo esc_html( $objetivo ); ?></p>
                        <?php endif; ?>

                        <dl class="evento-item__datos">
                            <?php if ( $fecha ) : ?>
                                <div><dt>Fecha</dt><dd><?php echo esc_html( $fecha ); ?></dd></div>
                            <?php endif; ?>
                            <?php if ( $hora ) : ?>
                                <div><dt>Hora</dt><dd><?php echo esc_html( $hora ); ?></dd></div>
                            <?php endif; ?>
                            <?php if ( $duracion ) : ?>
                                <div><dt>Duración</dt><dd><?php echo esc_html( $duracion ); ?></dd></div>
                            <?php endif; ?>
                            <?php if ( $modalidad === 'presencial' && $direccion ) : ?>
                                <div><dt>Ubicación</dt><dd><?php echo esc_html( $direccion ); ?></dd></div>
                            <?php endif; ?>
                            <?php if ( $precio ) : ?>
                                <div><dt>Precio</dt><dd><?php echo esc_html( $precio ); ?></dd></div>
                            <?php endif; ?>
                            <?php if ( $metodos_pago ) : ?>
                                <div><dt>Métodos de pago</dt><dd><?php echo esc_html( $metodos_pago ); ?></dd></div>
                            <?php endif; ?>
                            <?php if ( $cupo ) : ?>
                                <div><dt>Cupo</dt><dd><?php echo esc_html( $cupo ); ?> personas</dd></div>
                            <?php endif; ?>
                            <?php if ( $publico_objetivo ) : ?>
                                <div><dt>Dirigido a</dt><dd><?php echo esc_html( $publico_objetivo ); ?></dd></div>
                            <?php endif; ?>
                        </dl>

                        <?php if ( $requisitos ) : ?>
                            <p class="evento-item__requisitos"><strong>Requisitos:</strong> <?php echo esc_html( $requisitos ); ?></p>
                        <?php endif; ?>

                        <?php if ( $medio_contacto ) : ?>
                            <p class="evento-item__cta">
                                <span class="btn btn-primario">Inscríbete o pide informes: <?php echo esc_html( $medio_contacto ); ?></span>
                            </p>
                        <?php endif; ?>

                    </div>

                </article>

            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>

        <?php else : ?>

            <div class="cursos-vacio fade-in-al-scroll">
                <h2>Pronto habrá novedades</h2>
                <p>Aún no hay eventos programados en Espacio Violeta. Vuelve pronto para conocer las próximas fechas.</p>
            </div>

        <?php endif; ?>

    </div>
</section>

<?php get_footer(); ?>