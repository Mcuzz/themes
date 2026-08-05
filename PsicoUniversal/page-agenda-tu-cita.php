<?php get_header(); ?>

<?php
while ( have_posts() ) :
    the_post();
    $contenido_pagina = get_the_content();
endwhile;

$estado_cita = isset( $_GET['cita'] ) ? sanitize_key( wp_unslash( $_GET['cita'] ) ) : '';
?>

<section class="pagina-header">
    <div class="pagina-header__card">
        <h1><?php the_title(); ?></h1>
        <?php if ( $contenido_pagina ) : ?>
            <div class="pagina-header__intro"><?php echo apply_filters( 'the_content', $contenido_pagina ); ?></div>
        <?php endif; ?>
    </div>
</section>

<section class="agenda-seccion">
    <div class="contenedor contenedor--angosto">
        <?php if ( 'exito' === $estado_cita ) : ?>
            <div class="aviso aviso--exito" role="status">
                <h2>Gracias por contactarte</h2>
                <p>Tu solicitud fue recibida correctamente. Te confirmamos por correo electronico y muy pronto nos pondremos en contacto contigo por WhatsApp.</p>
            </div>
        <?php else : ?>
            <?php if ( 'error' === $estado_cita ) : ?>
                <div class="aviso aviso--error" role="alert">
                    <p>Hubo un problema con tu solicitud. Revisa que todos los campos esten completos y correctos, e intentalo de nuevo en un minuto.</p>
                </div>
            <?php endif; ?>

            <form class="form-cita" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
                <input type="hidden" name="action" value="enviar_cita">
                <?php wp_nonce_field( 'alicia_enviar_cita', 'alicia_cita_nonce' ); ?>

                <div class="form-cita__campo form-cita__campo--trampa" aria-hidden="true">
                    <label for="sitio_web">Sitio web</label>
                    <input type="text" id="sitio_web" name="sitio_web" tabindex="-1" autocomplete="off">
                </div>

                <div class="form-cita__campo">
                    <label for="nombre">Nombre completo</label>
                    <input type="text" id="nombre" name="nombre" autocomplete="name" maxlength="120" required>
                </div>

                <div class="form-cita__campo">
                    <label for="ciudad_pais">Ciudad / Pais</label>
                    <input type="text" id="ciudad_pais" name="ciudad_pais" autocomplete="address-level2" maxlength="120" required>
                </div>

                <div class="form-cita__campo">
                    <label for="correo">Correo electronico</label>
                    <input type="email" id="correo" name="correo" autocomplete="email" maxlength="120" required>
                    <span class="form-cita__ayuda">Aqui te enviaremos la confirmacion de recibido.</span>
                </div>

                <div class="form-cita__campo">
                    <label for="whatsapp">Numero de WhatsApp</label>
                    <input type="tel" id="whatsapp" name="whatsapp" autocomplete="tel" inputmode="tel" placeholder="Incluye codigo de pais, ej. +52 662 123 4567" maxlength="24" required>
                </div>

                <fieldset class="form-cita__campo">
                    <legend>Modalidad de cita</legend>
                    <label class="form-cita__radio"><input type="radio" name="modalidad" value="presencial" required> Presencial</label>
                    <label class="form-cita__radio"><input type="radio" name="modalidad" value="en_linea"> En linea</label>
                </fieldset>

                <button type="submit" class="btn btn-primario">Enviar solicitud</button>
            </form>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>
