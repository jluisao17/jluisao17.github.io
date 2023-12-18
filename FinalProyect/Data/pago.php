<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <title> Formulario de Pago </title>
    <link rel = "stylesheet" href = "styles/pago2.css"/>
    <script>
        // Listen for the browser's back button click event
        window.addEventListener('popstate', function(event) {
            // Redirect to the desired URL when the back button is clicked
            window.location.href = 'http://localhost/FinalProyect/404.html';
        });
    </script>
</head>
<body>
    <!-- Contenedor del formulario de pago -->
<div class="container">
    <form id="formdepago">
        <div class="row">
            <div class="col">
                <h3 class="title">Dirección de Facturación</h3>
                <div class="inputBox">
                    <span>Nombre Completo :</span>
                    <input type="text" placeholder="Nombre(s) y Apellidos" required>
                </div>
                <div class="inputBox">
                    <span>email :</span>
                    <input type="email" placeholder="ejemplo@ejemplo.com" required>
                </div>
                <div class="inputBox">
                    <span>Dirección :</span>
                    <input type="text" placeholder="# Casa - Calle" required>
                </div>
                <div class="inputBox">
                    <span>ciudad :</span>
                    <input type="text" placeholder="Ciudad" required>
                </div>
                <div class="flex">
                    <div class="inputBox delay1">
                        <span>Estado :</span>
                        <input type="text" placeholder="Estado" required>
                    </div>
                    <div class="inputBox delay1">
                        <span>Codigo Postal :</span>
                        <input type="text" maxlength = "5" placeholder="66666" required>
                    </div>
                </div>
            </div>
            <!--  Segunda fila del formulario de pago -->
            <div class="col">
                <h3 class="title">Pago</h3>
                <div class="inputBox">
                    <span>Tarjetas Aceptadas :</span>
                    <img src="/tiquin/images/card_img.png" alt="">
                </div>
                <div class="inputBox">
                    <span>Nombre en la tarjeta :</span>
                    <input type="text" class = "debit" placeholder="Ingresa Nombre en la Tarjeta" required>
                </div>
                <div class="inputBox">
                    <span>Numero de la tarjeta :</span>
                    <input type="text" maxlength = "16" placeholder="1234-1234-1234-1234" required>
                </div>
                <div class="inputBox">
                    <span>Mes de expiración :</span>
                    <input type="text" maxlength = "10" placeholder="Octubre" required>
                </div>
                <div class="flex">
                    <div class="inputBox">
                        <span>Año de expiración :</span>
                        <input type="text" maxlength = "4" placeholder="2023" required>
                    </div>
                    <div class="inputBox">
                        <span>CVV :</span>
                        <input type="text" maxlength = "3" placeholder="124" required>
                    </div>
                </div>
            </div>
        </div>
        <label class = "loading-text--none"></label>
        <span class="loading-btn-wrapper">
            <button type = "submit" class="loading-btn js_success-animation-trigger">
            <span class="loading-btn__text">
            Pagar
            </span>
            </button>
        </span>
    </form>

<script>
    console.log("test a ver si jala el script");
// Obtener el elemento del formulario
const paymentForm = document.getElementById('formdepago');

// Obtener el botón de envío
const submitBtn = document.querySelector('.loading-btn');

const pendingText = document.querySelector('.loading-text--none');

// Agregar un event listener para la presentación del formulario
paymentForm.addEventListener('submit', function (event) {
  // Evitar la presentación de formulario por defecto
event.preventDefault();

  // Validar los campos del formulario
if (validateForm()) {
    // Si el formulario es válido, activar la animación del botón
    triggerButtonAnimation();

    // Simular la duración de la animación (ajustar según la duración real de la animación)
    const animationDuration = 12450;
    
    // Esperar a que termine la animación y luego redirigir
    setTimeout(() => {
      // Redirigir a la URL deseada
    window.location.href = 'http://localhost/FinalProyect/index.html';
    }, animationDuration);
}
});

// Función para validar el formulario
function validateForm() {
let isValid = true;
  // Iterar a través de los campos del formulario y verificar si están vacíos
const formInputs = document.querySelectorAll('#formdepago input[required]');
formInputs.forEach((input) => {
    if (input.value.trim() === '') {
    isValid = false;
      // Agregar una clase de error para resaltar el campo con un error
    input.classList.add('error');
    }else {
      // Eliminar cualquier clase de error previa
    input.classList.remove('error');
    }
});

return isValid;
}

// Función para activar la animación del botón
function triggerButtonAnimation() {
submitBtn.classList.add('loading-btn--pending');
pendingText.classList.add('active');
pendingText.innerHTML = "Procesando Pago, No Vaya a Cerrar la Página.";
pendingText.style.color = "orange";

setTimeout(() => {
    submitBtn.classList.remove('loading-btn--pending');
    pendingText.innerHTML = "Pago Realizado Correctamente";
    pendingText.style.color = "green";
    pendingText.style.marginLeft = "60px";
    submitBtn.classList.add('loading-btn--success');

    setTimeout(() => submitBtn.classList.remove('loading-btn--success'), 2000);
    setTimeout(() => pendingText.classList.remove('active'), 3000);
    setTimeout(() => pendingText.innerHTML = "Que tenga un buen día :)", 2000);
    setTimeout(() => pendingText.style.marginLeft = "80px", 2000);
}, 8000);
pendingText.style.marginLeft = "0";
}



const cards = document.querySelectorAll(".inputBox");

const observador = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        entry.target.classList.toggle("animation", entry.isIntersecting)
    })
})
cards.forEach(card => {
    observador.observe(card);
});
</script>

</div>    
    
</body>
</html>
