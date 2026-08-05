<?php get_header(); ?>

<!-- ============================================
     BIOGRAFÍA
     Usa el título y contenido normales de la Página
     "Sobre mí" (editor estándar de WordPress), más la
     imagen destacada de esa misma Página como retrato.
     ============================================ -->
<section class="bio-seccion">
    <div class="contenedor bio-seccion__grid">

        <?php if ( has_post_thumbnail() ) : ?>
            <div class="bio-seccion__foto">
                <?php the_post_thumbnail( 'medium_large', array( 'alt' => 'Alicia Monzalvo' ) ); ?>
            </div>
        <?php endif; ?>

        <div class="bio-seccion__texto">
            <h1><?php the_title(); ?></h1>
            <?php
            while ( have_posts() ) : the_post();
                the_content();
            endwhile;
            ?>
        </div>

    </div>
</section>

<!-- ============================================
     FORMACIÓN ACADÉMICA
     ============================================ -->
<section class="formacion-seccion">
    <div class="contenedor">
        <h2 class="seccion-titulo">Formación académica</h2>

        <?php
        $formacion_query = new WP_Query( array(
            'post_type'      => 'formacion_academica',
            'posts_per_page' => -1,
            'orderby'        => 'menu_order',
            'order'          => 'ASC',
        ) );
        ?>

        <?php if ( $formacion_query->have_posts() ) : ?>
            <ul class="formacion-lista">
                <?php while ( $formacion_query->have_posts() ) : $formacion_query->the_post(); ?>
                    <?php
                    $institucion = get_field( 'institucion' );
                    $anio        = get_field( 'anio_conclusion' );
                    ?>
                    <li class="formacion-item fade-in-al-scroll">
                        <span class="formacion-item__anio"><?php echo $anio ? esc_html( $anio ) : '—'; ?></span>
                        <span>
                            <?php the_title(); ?>
                            <?php if ( $institucion ) : ?>
                                <span class="formacion-item__institucion"><?php echo esc_html( $institucion ); ?></span>
                            <?php endif; ?>
                        </span>
                    </li>
                <?php endwhile; wp_reset_postdata(); ?>
            </ul>
        <?php else : ?>
            <p class="seccion-vacio">Próximamente se agregará el detalle de formación académica.</p>
        <?php endif; ?>

        <?php
        $etiquetas = get_field( 'etiquetas_formacion', 'option' );
        if ( $etiquetas ) :
            $grupos = array();
            foreach ( $etiquetas as $et ) {
                $grupos[ $et['categoria'] ][] = $et['texto'];
            }
            $nombres_categoria = array(
                'diplomado'          => 'Diplomados',
                'formacion_continua' => 'Formación continua',
                'reconocimiento'     => 'Reconocimientos',
                'afiliacion'         => 'Afiliaciones',
            );
            ?>
            <div class="etiquetas-formacion fade-in-al-scroll">
                <?php foreach ( $grupos as $cat => $items ) : ?>
                    <div class="etiquetas-formacion__grupo">
                        <h3 class="etiquetas-formacion__titulo"><?php echo esc_html( $nombres_categoria[ $cat ] ?? $cat ); ?></h3>
                        <div class="etiquetas-formacion__lista">
                            <?php foreach ( $items as $texto ) : ?>
                                <span class="etiqueta etiqueta--<?php echo esc_attr( $cat ); ?>"><?php echo esc_html( $texto ); ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- ============================================
     EXPERIENCIA PROFESIONAL
     ============================================ -->
<section class="experiencia-seccion">
    <div class="contenedor">
        <h2 class="seccion-titulo">Experiencia profesional</h2>

        <?php
        $experiencia_query = new WP_Query( array(
            'post_type'      => 'experiencia_profesional',
            'posts_per_page' => -1,
            'orderby'        => 'menu_order date',
            'order'          => 'DESC',
        ) );
        ?>

        <?php if ( $experiencia_query->have_posts() ) : ?>
            <div class="experiencia-grid">
                <?php while ( $experiencia_query->have_posts() ) : $experiencia_query->the_post(); ?>
                    <?php
                    $periodo         = get_field( 'periodo' );
                    $especialidades  = get_field( 'especialidades' );
                    $logros          = get_field( 'logros' );
                    ?>
                    <article class="experiencia-card fade-in-al-scroll">
                        <h3><?php the_title(); ?></h3>
                        <?php if ( $periodo ) : ?>
                            <p class="experiencia-card__periodo"><?php echo esc_html( $periodo ); ?></p>
                        <?php endif; ?>
                        <?php if ( $especialidades ) : ?>
                            <p><strong>Especialidades:</strong> <?php echo esc_html( $especialidades ); ?></p>
                        <?php endif; ?>
                        <?php if ( $logros ) : ?>
                            <p><strong>Logros:</strong> <?php echo esc_html( $logros ); ?></p>
                        <?php endif; ?>
                    </article>
                <?php endwhile; ?>
            </div>
            <?php wp_reset_postdata(); ?>
        <?php else : ?>
            <p class="seccion-vacio">Próximamente se agregará el detalle de experiencia profesional.</p>
        <?php endif; ?>
    </div>
</section>

<!-- ============================================
     PUBLICACIONES (LIBROS)
     ============================================ -->
<section class="publicaciones-seccion">
    <div class="contenedor">
        <h2 class="seccion-titulo">Publicaciones</h2>

        <?php
        $publicaciones_query = new WP_Query( array(
            'post_type'      => 'publicacion',
            'posts_per_page' => -1,
            'orderby'        => 'meta_value_num',
            'meta_key'       => 'anio_publicacion',
            'order'          => 'DESC',
        ) );
        ?>

        <?php if ( $publicaciones_query->have_posts() ) : ?>
            <div class="publicaciones-grid">
                <?php while ( $publicaciones_query->have_posts() ) : $publicaciones_query->the_post(); ?>
                    <?php
                    $anio      = get_field( 'anio_publicacion' );
                    $editorial = get_field( 'editorial' );
                    $enlace    = get_field( 'enlace_compra' );
                    ?>
                    <article class="publicacion-card fade-in-al-scroll">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="publicacion-card__portada">
                                <?php the_post_thumbnail( 'medium', array( 'loading' => 'lazy', 'alt' => get_the_title() ) ); ?>
                            </div>
                        <?php endif; ?>
                        <div class="publicacion-card__info">
                            <h3><?php the_title(); ?></h3>
                            <?php if ( $anio || $editorial ) : ?>
                                <p class="publicacion-card__meta">
                                    <?php echo esc_html( trim( $editorial . ( $anio ? ' · ' . $anio : '' ), ' ·' ) ); ?>
                                </p>
                            <?php endif; ?>
                            <div class="publicacion-card__descripcion"><?php the_content(); ?></div>
                            <?php if ( $enlace ) : ?>
                                <a href="<?php echo esc_url( $enlace ); ?>" class="btn-secundario" target="_blank" rel="noopener">Ver publicación</a>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
            <?php wp_reset_postdata(); ?>
        <?php else : ?>
            <p class="seccion-vacio">Próximamente se agregarán las publicaciones.</p>
        <?php endif; ?>
    </div>
</section>

<!-- ============================================
     PODCAST / YOUTUBE
     ============================================ -->
<section class="podcast-seccion">
    <div class="contenedor">
        <h2 class="seccion-titulo">Podcast</h2>

        <?php
        $podcast_query = new WP_Query( array(
            'post_type'      => 'podcast_episodio',
            'posts_per_page' => -1,
            'orderby'        => 'date',
            'order'          => 'DESC',
        ) );
        ?>

        <?php if ( $podcast_query->have_posts() ) : ?>
            <div class="podcast-grid">
                <?php while ( $podcast_query->have_posts() ) : $podcast_query->the_post(); ?>
                    <?php $enlace_youtube = get_field( 'enlace_youtube' ); ?>
                    <article class="podcast-card fade-in-al-scroll">
                        <?php if ( $enlace_youtube ) : ?>
                            <div class="podcast-card__video">
                                <?php echo wp_oembed_get( $enlace_youtube ); ?>
                            </div>
                        <?php endif; ?>
                        <div class="podcast-card__info">
                            <h3><?php the_title(); ?></h3>
                            <div class="podcast-card__descripcion"><?php the_content(); ?></div>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
            <?php wp_reset_postdata(); ?>
        <?php else : ?>
            <p class="seccion-vacio">Próximamente se agregarán episodios del podcast.</p>
        <?php endif; ?>
    </div>
</section>

<!-- ============================================
     INVESTIGACIONES
     ============================================ -->
<section class="investigaciones-seccion">
    <div class="contenedor">
        <h2 class="seccion-titulo">Investigaciones</h2>

        <h3 class="seccion-subtitulo">Líneas de investigación</h3>
        <?php
        alicia_grid_etiquetas( array(
            'Salud mental',
            'Regulación emocional',
            'Calidad de vida',
            'Interculturalidad',
            'Migración',
            'Inclusión educativa',
            'Discapacidad',
            'Autismo',
            'Competencias socioemocionales',
        ) );
        ?>

        <?php
        $investigacion_query = new WP_Query( array(
            'post_type'      => 'investigacion',
            'posts_per_page' => -1,
            'orderby'        => 'meta_value_num',
            'meta_key'       => 'anio',
            'order'          => 'DESC',
        ) );
        ?>

        <?php if ( $investigacion_query->have_posts() ) : ?>
            <ul class="investigaciones-lista">
                <?php while ( $investigacion_query->have_posts() ) : $investigacion_query->the_post(); ?>
                    <?php
                    $anio_inv = get_field( 'anio' );
                    $enlace_doc = get_field( 'enlace_documento' );
                    ?>
                    <li class="investigacion-item fade-in-al-scroll">
                        <h3><?php the_title(); ?> <?php if ( $anio_inv ) : ?><span class="investigacion-item__anio">(<?php echo esc_html( $anio_inv ); ?>)</span><?php endif; ?></h3>
                        <div class="investigacion-item__resumen"><?php the_content(); ?></div>
                        <?php if ( $enlace_doc ) : ?>
                            <a href="<?php echo esc_url( $enlace_doc ); ?>" target="_blank" rel="noopener">Ver documento →</a>
                        <?php endif; ?>
                    </li>
                <?php endwhile; ?>
            </ul>
            <?php wp_reset_postdata(); ?>
        <?php else : ?>
            <p class="seccion-vacio">Próximamente se agregarán investigaciones.</p>
        <?php endif; ?>
    </div>
</section>

<!-- ============================================
     BLOG / PUBLICACIONES OCASIONALES
     Usa las Entradas nativas de WordPress (Posts),
     no un Custom Post Type — Alicia las crea desde
     "Entradas → Añadir nueva", como cualquier blog.
     ============================================ -->
<section class="blog-seccion">
    <div class="contenedor">
        <h2 class="seccion-titulo">Blog y publicaciones ocasionales</h2>

        <?php
        $blog_query = new WP_Query( array(
            'post_type'      => 'post',
            'posts_per_page' => 3,
        ) );
        ?>

        <?php if ( $blog_query->have_posts() ) : ?>
            <div class="blog-grid">
                <?php while ( $blog_query->have_posts() ) : $blog_query->the_post(); ?>
                    <article class="blog-card fade-in-al-scroll">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <a href="<?php the_permalink(); ?>" class="blog-card__imagen">
                                <?php the_post_thumbnail( 'medium', array( 'loading' => 'lazy', 'alt' => get_the_title() ) ); ?>
                            </a>
                        <?php endif; ?>
                        <div class="blog-card__info">
                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 20 ) ); ?></p>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
            <?php wp_reset_postdata(); ?>
            <p class="blog-ver-mas"><a href="<?php echo esc_url( home_url( '/blog' ) ); ?>">Ver todas las publicaciones →</a></p>
        <?php else : ?>
            <p class="seccion-vacio">Próximamente encontrarás aquí publicaciones ocasionales.</p>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>