document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('form-agenda-cita');
  if (!form) return;

  const btnEnviar = document.getElementById('btn-enviar-cita');
  const mensajeResultado = document.getElementById('form-mensaje-resultado');

  const mensajesError = {
    nombre: 'Por favor escribe tu nombre.',
    ciudad_pais: 'Cuéntanos desde dónde nos escribes.',
    correo: 'Necesitamos un correo válido para contactarte.',
    whatsapp: 'Escribe un número de WhatsApp válido.',
    modalidad: 'Elige una modalidad de cita.',
  };

  function limpiarErrores() {
    form.querySelectorAll('.form-error').forEach(el => el.textContent = '');
    form.querySelectorAll('.input-invalido').forEach(el => el.classList.remove('input-invalido'));
  }

  function mostrarError(campo, mensaje) {
    const errorSpan = form.querySelector(`[data-error-for="${campo}"]`);
    if (errorSpan) errorSpan.textContent = mensaje;

    const input = form.querySelector(`[name="${campo}"]`);
    if (input) input.classList.add('input-invalido');
  }

  function validarFormulario(data) {
    let valido = true;
    limpiarErrores();

    if (!data.nombre.trim()) {
      mostrarError('nombre', mensajesError.nombre);
      valido = false;
    }
    if (!data.ciudad_pais.trim()) {
      mostrarError('ciudad_pais', mensajesError.ciudad_pais);
      valido = false;
    }
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(data.correo)) {
      mostrarError('correo', mensajesError.correo);
      valido = false;
    }
    const whatsappLimpio = data.whatsapp.replace(/\D/g, '');
    if (whatsappLimpio.length < 10) {
      mostrarError('whatsapp', mensajesError.whatsapp);
      valido = false;
    }
    if (!data.modalidad) {
      mostrarError('modalidad', mensajesError.modalidad);
      valido = false;
    }

    return valido;
  }

  form.addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());

    if (!validarFormulario(data)) {
      mensajeResultado.textContent = 'Revisa los campos marcados, falta un poco de información.';
      mensajeResultado.className = 'form-mensaje-resultado mensaje-atencion';
      return;
    }

    // Honeypot: si tiene contenido, es spam, fingimos éxito y no enviamos nada
    if (data.sitio_web) {
      mensajeResultado.textContent = 'Gracias, tu solicitud fue enviada.';
      mensajeResultado.className = 'form-mensaje-resultado mensaje-exito';
      form.reset();
      return;
    }

    btnEnviar.classList.add('cargando');
    btnEnviar.disabled = true;
    mensajeResultado.textContent = '';

    const payload = new URLSearchParams();
    payload.append('action', 'pu_enviar_solicitud_cita');
    payload.append('nonce', agendaCitaData.nonce);
    Object.keys(data).forEach(key => payload.append(key, data[key]));

    fetch(agendaCitaData.ajaxUrl, {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: payload.toString(),
    })
      .then(res => res.json())
      .then(res => {
        btnEnviar.classList.remove('cargando');
        btnEnviar.disabled = false;

        if (res.success) {
          mensajeResultado.textContent = res.data.mensaje || 'Tu solicitud fue enviada con éxito. Pronto te contactaremos.';
          mensajeResultado.className = 'form-mensaje-resultado mensaje-exito';
          form.reset();
        } else {
          mensajeResultado.textContent = res.data.mensaje || 'Hubo un problema al enviar tu solicitud. Intenta de nuevo.';
          mensajeResultado.className = 'form-mensaje-resultado mensaje-error';
        }
      })
      .catch(() => {
        btnEnviar.classList.remove('cargando');
        btnEnviar.disabled = false;
        mensajeResultado.textContent = 'No pudimos conectar. Por favor revisa tu conexión e intenta de nuevo.';
        mensajeResultado.className = 'form-mensaje-resultado mensaje-error';
      });
  });
});