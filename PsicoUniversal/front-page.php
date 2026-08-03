<?php get_header(); ?>

<!-- ============================================
     HERO — foto y frase de Alicia
     ============================================ -->
<section class="hero-inicio">

    <?php $hero_foto = alicia_campo( 'hero_foto', alicia_opciones_sitio_id() ); ?>

    <div
        class="contenedor hero-inicio__grid"
        <?php if ( $hero_foto ) : ?>
            style="background-image:url('<?php echo esc_url( $hero_foto ); ?>');"
        <?php endif; ?>
    >

        <div class="hero-inicio__texto">

            <h1>
                <?php
                $frase_principal = alicia_campo( 'hero_frase_principal', alicia_opciones_sitio_id() );
                echo esc_html( $frase_principal ? $frase_principal : 'Un espacio seguro para reencontrarte contigo.' );
                ?>
            </h1>

            <?php
            $frase_secundaria = alicia_campo( 'hero_frase_secundaria', alicia_opciones_sitio_id() );
            if ( $frase_secundaria ) :
            ?>
                <p class="hero-inicio__subtitulo">
                    <?php echo esc_html( $frase_secundaria ); ?>
                </p>
            <?php endif; ?>

            <a href="<?php echo esc_url( alicia_url_pagina( 'agenda-tu-cita' ) ); ?>" class="btn btn-primario">
                Agenda tu cita
            </a>

        </div>

    </div>

</section>

<!-- ============================================
     INTRODUCCIÓN
============================================ -->
<section class="intro-seccion">
    <div class="contenedor">

        <?php
        $bloques_intro = array(
            'intro_quien_soy'    => '¿Quién soy?',
            'intro_en_que_ayudo' => '¿En qué te puedo ayudar?',
            'intro_enfoque'      => '¿Cuál es mi enfoque?',
        );

        // Cargar las imágenes una sola vez
        $galeria = array();
        for ( $i = 1; $i <= 5; $i++ ) {
            $foto = alicia_campo( "galeria_foto_$i", alicia_opciones_sitio_id() );
            if ( $foto ) {
                $galeria[] = $foto;
            }
        }

        $indice = 0;
        ?>

        <div class="intro-grid">

            <?php foreach ( $bloques_intro as $campo => $titulo ) :

                $contenido = alicia_campo( $campo, alicia_opciones_sitio_id() );

                if ( ! $contenido ) continue;

                $foto = $galeria[$indice] ?? null;
            ?>

                <article class="intro-item fade-in-al-scroll">

                    <div class="intro-item__texto">
                        <h2><?php echo esc_html( $titulo ); ?></h2>
                        <div class="intro-card__texto">
                            <?php echo wp_kses_post( $contenido ); ?>
                        </div>
                    </div>

                    <?php if ( $foto ) : ?>
                        <div class="intro-item__imagen">
                            <img
                                src="<?php echo esc_url( $foto ); ?>"
                                alt="<?php echo esc_attr( $titulo ); ?>"
                                loading="lazy">
                        </div>
                    <?php endif; ?>

                </article>

            <?php
                $indice++;
            endforeach;
            ?>

        </div>

    </div>
</section>

<!-- ============================================
     TESTIMONIOS
     ============================================ -->
<section class="testimonios-seccion">
    <div class="contenedor">
        <h2 class="testimonios-titulo">Descubre lo que las personas han dicho de su experiencia en terapia conmigo</h2>

        <?php
        $testimonios_query = new WP_Query( array(
            'post_type'      => 'testimonio',
            'posts_per_page' => 6,
            'orderby'        => 'date',
            'order'          => 'DESC',
        ) );
        ?>

        <?php if ( $testimonios_query->have_posts() ) : ?>
            <div class="testimonios-grid">
                <?php while ( $testimonios_query->have_posts() ) : $testimonios_query->the_post(); ?>
                    <blockquote class="testimonio-card fade-in-al-scroll">
                        <p class="testimonio-card__texto">&ldquo;<?php echo esc_html( wp_strip_all_tags( get_the_content() ) ); ?>&rdquo;</p>
                        <footer class="testimonio-card__autor">
                            <cite><?php the_title(); ?></cite>
                            <?php $ciudad = get_field( 'ciudad_pais' ); ?>
                            <?php if ( $ciudad ) : ?>
                                <span class="testimonio-card__ciudad"><?php echo esc_html( $ciudad ); ?></span>
                            <?php endif; ?>
                        </footer>
                    </blockquote>
                <?php endwhile; ?>
            </div>
            <?php wp_reset_postdata(); ?>
        <?php else : ?>
            <p class="testimonios-vacio">Pronto encontrarás aquí testimonios reales de quienes han confiado en este proceso.</p>
        <?php endif; ?>
    </div>
</section>
<<div class="promo-flotante">

    <button
        id="abrirPromociones"
        class="promo-flotante__boton">

        🏷
        <span>Promociones<br>del mes</span>

    </button>

</div>

<div class="promo-modal" id="promoModal">

    <div class="promo-modal__contenido">

        <button
            class="promo-modal__cerrar"
            id="cerrarPromociones">

            ✕

        </button>

        <h2>Promociones del mes</h2>

        <p>
            Aquí puedes colocar cualquier información:
        </p>

        <ul>
            <li>Primera consulta con descuento.</li>
            <li>Paquete de sesiones.</li>
            <li>Promoción para estudiantes.</li>
        </ul>

    </div>

</div>
<?php get_footer(); ?>
