</main><!-- cierra #contenido-principal -->

    <footer class="sitio-footer">
        <div class="contenedor footer-grid">

            <!-- ===== REDES SOCIALES ===== -->
            <div class="footer-col">
                <h3>Sígueme</h3>
                <div class="footer-redes">
                    <?php
                    $redes = array(
                        'url_facebook'  => 'Facebook',
                        'url_instagram' => 'Instagram',
                        'url_youtube'   => 'YouTube',
                        'url_tiktok'    => 'TikTok',
                        'url_linkedin'  => 'LinkedIn',
                    );
                    foreach ( $redes as $campo => $nombre_red ) :
                        $url = alicia_campo( $campo, alicia_opciones_sitio_id() );
                        if ( ! $url ) continue;
                    ?>
                        <a href="<?php echo esc_url( $url ); ?>" class="footer-red-icono" target="_blank" rel="noopener" aria-label="<?php echo esc_attr( $nombre_red ); ?>">
                            <?php alicia_icono_red( $nombre_red ); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- ===== CONTACTO ===== -->
            <div class="footer-col">
                <h3>Contacto</h3>
                <ul class="footer-contacto-lista">
                    <?php $correo = alicia_campo( 'correo_contacto', alicia_opciones_sitio_id() ); ?>
                    <?php if ( $correo ) : ?>
                        <li><a href="mailto:<?php echo esc_attr( $correo ); ?>"><?php echo esc_html( $correo ); ?></a></li>
                    <?php endif; ?>

                    <?php $telefono = alicia_campo( 'telefono_whatsapp', alicia_opciones_sitio_id() ); ?>
                    <?php if ( $telefono ) : ?>
                        <?php $url_whatsapp = alicia_url_whatsapp( $telefono ); ?>
                        <li>
                            <?php if ( $url_whatsapp ) : ?>
                                <a href="<?php echo esc_url( $url_whatsapp ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $telefono ); ?></a>
                            <?php else : ?>
                                <?php echo esc_html( $telefono ); ?>
                            <?php endif; ?>
                        </li>
                    <?php endif; ?>

                    <?php $ciudad_estado = alicia_campo( 'ciudad_estado', alicia_opciones_sitio_id() ); ?>
                    <?php if ( $ciudad_estado ) : ?>
                        <li><?php echo esc_html( $ciudad_estado ); ?></li>
                    <?php endif; ?>

                    <?php $horarios = alicia_campo( 'horarios_atencion', alicia_opciones_sitio_id() ); ?>
                    <?php if ( $horarios ) : ?>
                        <li class="footer-horarios"><?php echo nl2br( esc_html( $horarios ) ); ?></li>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- ===== CTA ===== -->
            <div class="footer-col footer-cta">
                <p class="frase-motivante">Dar el primer paso ya es un acto de valentía.</p>
                <a href="<?php echo esc_url( alicia_url_pagina( 'agenda-tu-cita' ) ); ?>" class="btn btn-primario">Agenda tu cita</a>
            </div>

        </div>

        <div class="footer-legal">
            <div class="contenedor">
                <p>
                    <?php
                    $nombre_prof = alicia_campo( 'nombre_profesional_completo', alicia_opciones_sitio_id() );
                    $titulo_prof = alicia_campo( 'titulo_profesional', alicia_opciones_sitio_id() );
                    echo esc_html( $nombre_prof ? $nombre_prof : get_bloginfo( 'name' ) );
                    if ( $titulo_prof ) echo ' — ' . esc_html( $titulo_prof );
                    ?>
                    &copy; <?php echo esc_html( date( 'Y' ) ); ?>
                </p>
            </div>
        </div>

    </footer>

    <div class="promo-flotante">
    <button id="abrirPromociones" class="promo-flotante__boton" aria-haspopup="dialog" aria-controls="promoModal">
        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M20.6 12.4 12.4 20.6a2 2 0 0 1-2.8 0l-6.2-6.2a2 2 0 0 1 0-2.8L11.6 3.4a2 2 0 0 1 1.4-.6H19a2 2 0 0 1 2 2v6.2a2 2 0 0 1-.4 1.4Z"/>
            <circle cx="15.5" cy="7.5" r="1.5"/>
        </svg>
        <span>Promociones<br>del mes</span>
    </button>
</div>

<div class="promo-modal" id="promoModal" role="dialog" aria-modal="true" aria-labelledby="promoModalTitulo">
    <div class="promo-modal__contenido">
        <button class="promo-modal__cerrar" id="cerrarPromociones" aria-label="Cerrar promociones">✕</button>
        <h2 id="promoModalTitulo">Promociones del mes</h2>
        <p>Aquí puedes colocar cualquier información:</p>
        <ul>
            <li>Primera consulta con descuento.</li>
            <li>Paquete de sesiones.</li>
            <li>Promoción para estudiantes.</li>
        </ul>
    </div>
</div>

    <?php wp_footer(); ?>
</body>
</html>
