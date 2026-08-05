<?php get_header(); ?>

<!-- ============================================
     HERO — foto y frase de Alicia
     ============================================ -->
<section class="hero">

<?php $hero_foto = alicia_campo( 'hero_foto', alicia_opciones_sitio_id() ); ?>

<div
    class="contenedor hero__grid"
    <?php if ( $hero_foto ) : ?>
        style="background-image:url('<?php echo esc_url( $hero_foto ); ?>');"
    <?php endif; ?>
>

    <div class="hero__texto">

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
                <p class="hero__subtitulo">
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
     POR QUÉ ELEGIR PSICOUNIVERSAL
     ============================================ -->
<section class="porque-elegir-seccion">
    <div class="contenedor">
        <h2 class="seccion-titulo">¿Por qué elegir PSICOUNIVERSAL?</h2>
        <p class="seccion-intro">
            En PSICOUNIVERSAL combinamos evidencia científica, experiencia clínica y un
            acompañamiento cercano para ofrecer procesos terapéuticos personalizados.
        </p>

        <?php
        alicia_grid_etiquetas( array(
            'Atención basada en evidencia científica',
            'Más de 15 años de experiencia clínica y universitaria',
            'Investigadora reconocida por el SNII',
            'Formación internacional',
            'Atención ética, cálida y confidencial',
            'Tratamientos personalizados',
        ) );
        ?>
    </div>
</section>

<!-- ============================================
     INTRODUCCIÓN
============================================ -->
<section class="intro-seccion">
    <div class="contenedor">

        <?php
        $bloques_intro = array(
            'intro_quien_soy'    => 'Recupera el equilibrio entre tu mente, tus emociones y tu vida', 
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

                        <?php if ( 'intro_en_que_ayudo' === $campo ) : ?>

                            <p class="intro-card__texto">
                                Brindamos atención psicológica para niños, adolescentes, adultos y parejas, acompañando procesos relacionados con:
                            </p>

                            <ul class="lista-ayuda">
    <li>Ansiedad</li>
    <li>Depresión</li>
    <li>Estrés</li>
    <li>Regulación emocional</li>
    <li>Autoestima</li>
    <li>Trauma</li>
    <li>Duelo</li>
    <li>Relaciones de pareja</li>
    <li>Desarrollo personal</li>
    <li>TDAH</li>
    <li>TEA</li>
</ul>

                            <p class="intro-card__texto">
                                Cada proceso terapéutico se adapta a tu historia, tus objetivos y tu ritmo de avance.
                            </p>

                        <?php else : ?>

                            <div class="intro-card__texto">
                                <?php echo wp_kses_post( $contenido ); ?>
                            </div>

                        <?php endif; ?>
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
                            <?php the_title(); ?>
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


<?php get_footer(); ?>