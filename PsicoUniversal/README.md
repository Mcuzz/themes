# Tema PsicoUniversal

Tema de WordPress para el sitio profesional de Psicouniversal. El contenido se administra desde WordPress y Advanced Custom Fields (ACF), sin editar las plantillas.

## Requisitos

- WordPress actualizado.
- El plugin gratuito Advanced Custom Fields activo.
- Un servicio SMTP configurado para WordPress. `wp_mail()` por si solo no garantiza la entrega de correos en un hosting.

## Configuracion inicial

1. Activa el tema y asigna un logotipo desde `Apariencia > Personalizar > Identidad del sitio`.
2. Crea las paginas con estos slugs: `terapias`, `cursos`, `espacio-violeta`, `sobre-mi`, `agenda-tu-cita` y `opciones-sitio`.
3. Asigna las plantillas de pagina correspondientes y define la pagina de inicio estatica desde `Ajustes > Lectura`.
4. En `opciones-sitio`, completa los datos profesionales, contacto, redes, hero, introduccion y galeria.
5. Crea y asigna el menu principal. Si todavia no existe, el tema muestra enlaces de respaldo a los modulos principales.
6. Agrega el contenido desde los tipos de entrada: Terapias, Testimonios, Eventos Espacio Violeta, Cursos, Publicaciones, Podcast, Investigaciones, Formacion Academica y Experiencia Profesional.

## Solicitudes de cita

El formulario guarda cada solicitud como una cita privada en WordPress, notifica al correo configurado en `opciones-sitio` y envia una confirmacion automatica a la persona interesada. El correo interno incluye un enlace para abrir WhatsApp con una respuesta preparada.

El envio automatico de mensajes por WhatsApp requiere una cuenta de WhatsApp Business API y un proveedor autorizado; el tema no envia mensajes de WhatsApp por si mismo. El formulario incluye nonce, campo trampa anti-spam y un limite de un envio por direccion IP cada minuto.
