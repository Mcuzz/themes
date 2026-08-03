document.addEventListener('DOMContentLoaded', function () {
    var menuButton = document.querySelector('.menu-toggle');
    var mainNavigation = document.querySelector('.nav-principal');

    document.documentElement.classList.add('js');

    if (menuButton && mainNavigation) {
        menuButton.addEventListener('click', function () {
            var isOpen = mainNavigation.classList.toggle('is-open');

            menuButton.setAttribute('aria-expanded', String(isOpen));
            menuButton.classList.toggle('is-open', isOpen);
        });

        mainNavigation.addEventListener('click', function (event) {
            if (event.target.closest('a') && window.matchMedia('(max-width: 767px)').matches) {
                mainNavigation.classList.remove('is-open');
                menuButton.classList.remove('is-open');
                menuButton.setAttribute('aria-expanded', 'false');
            }
        });
    }

    var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var elementos = document.querySelectorAll('.fade-in-al-scroll');

    if (reduceMotion || !('IntersectionObserver' in window)) {
        elementos.forEach(function (el) {
            el.classList.add('visible');
        });
    } else {
        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15 });

        elementos.forEach(function (el) {
            observer.observe(el);
        });
    }

    /* ==========================
       MODAL PROMOCIONES
    ========================== */

    var abrirPromo = document.getElementById('abrirPromociones');
    var cerrarPromo = document.getElementById('cerrarPromociones');
    var modalPromo = document.getElementById('promoModal');

    if (abrirPromo && cerrarPromo && modalPromo) {

        abrirPromo.addEventListener('click', function () {
            modalPromo.classList.add('activo');
            document.body.style.overflow = 'hidden';
        });

        cerrarPromo.addEventListener('click', function () {
            modalPromo.classList.remove('activo');
            document.body.style.overflow = '';
        });

        modalPromo.addEventListener('click', function (event) {
            if (event.target === modalPromo) {
                modalPromo.classList.remove('activo');
                document.body.style.overflow = '';
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                modalPromo.classList.remove('activo');
                document.body.style.overflow = '';
            }
        });

    }

});
