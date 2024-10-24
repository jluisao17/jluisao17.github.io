(function ($) {
    "use strict";

    // Cargando
    var spinner = function () {
        setTimeout(function () {
            if ($('#spinner').length > 0) {
                $('#spinner').removeClass('show');
            }
        }, 1);
    };
    spinner();
    
    
    // Iniciar los  wowjs
    new WOW().init();


    // Sticky Navbar
    $(window).scroll(function () {
        if ($(this).scrollTop() > 45) {
            $('.navbar').addClass('sticky-top shadow-sm');
        } else {
            $('.navbar').removeClass('sticky-top shadow-sm');
        }
    });
    
    
    // Despliegue del menu desplegable
    const $dropdown = $(".dropdown");
    const $dropdownToggle = $(".dropdown-toggle");
    const $dropdownMenu = $(".dropdown-menu");
    const showClass = "show";
    
    $(window).on("load resize", function() {
        if (this.matchMedia("(min-width: 992px)").matches) {
            $dropdown.hover(
            function() {
                const $this = $(this);
                $this.addClass(showClass);
                $this.find($dropdownToggle).attr("aria-expanded", "true");
                $this.find($dropdownMenu).addClass(showClass);
            },
            function() {
                const $this = $(this);
                $this.removeClass(showClass);
                $this.find($dropdownToggle).attr("aria-expanded", "false");
                $this.find($dropdownMenu).removeClass(showClass);
            }
            );
        } else {
            $dropdown.off("mouseenter mouseleave");
        }
    });
    
    
    // Boton para regresar hasta arriba
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
        return false;
    });


    // Carrusel de los comentarios
    $(".testimonial-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1000,
        center: true,
        margin: 24,
        dots: true,
        loop: true,
        nav : false,
        responsive: {
            0:{
                items:1
            },
            768:{
                items:2
            },
            992:{
                items:3
            }
        }
    });
    
})(jQuery);

// <------------------------ Separación epica ------------------------>

// Selecciona todos los elementos con la clase 'num'
const valueDisplays = document.querySelectorAll('.num');
// Establece el intervalo para la animación de conteo
let interval = 3200;

// Crea un objeto IntersectionObserver para detectar la visibilidad de los elementos en la pantalla
const observer = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
    // Si el elemento está siendo intersectado (visible en pantalla)
    if (entry.isIntersecting) {
      // Inicia la animación de conteo para el elemento actual
        startCounting(entry.target);
    } else {
      // Detiene la animación de conteo para el elemento actual
        stopCounting(entry.target);
    }
    });
}, { threshold: 0 }); // Establece el umbral en 0 para que el callback se active cuando al menos el 1% del elemento es visible
// Observa cada elemento con la clase 'num'
valueDisplays.forEach(valueDisplay => {
    observer.observe(valueDisplay);
});

// Función para iniciar la animación de conteo para un elemento específico
function startCounting(valueDisplay) {
    let startValue = 0;
  // Obtiene el valor final desde el atributo 'data-val' y lo convierte a entero
    let endValue = parseInt(valueDisplay.getAttribute('data-val'));
  // Calcula la duración de la animación basada en el intervalo y el valor final
    let duration = Math.floor(interval / endValue);
  // Crea un intervalo para actualizar gradualmente el contenido del elemento
    let counter = setInterval(() => {
    startValue += 1;
    valueDisplay.textContent = startValue;
    // Cuando se alcanza el valor final, se detiene el intervalo
    if (startValue === endValue) {
        clearInterval(counter);
    }
    }, duration);
  // Almacena el ID del intervalo en un atributo de datos para referencia futura
    valueDisplay.dataset.counter = counter;
}

// Función para detener la animación de conteo para un elemento específico
function stopCounting(valueDisplay) {
  // Obtiene el ID del intervalo almacenado en el atributo de datos
    let counter = valueDisplay.dataset.counter;
  // Si hay un intervalo asociado, lo detiene y elimina la referencia
    if (counter) {
    clearInterval(counter);
    delete valueDisplay.dataset.counter;
    }
}

//Animacion del boton de registrar

const register = document.getElementById('register-btn');
const input = document.getElementById('validate-input');

function validate(){
    if(input.value === ""){
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Tienes que rellenar el campo!"
        });
    } else {
        Swal.fire({
            title: "Genial!",
            text: "Email enviado exitosamente!",
            icon: "success"
        });
    }
}

register.addEventListener('click', () => {
    validate();
});