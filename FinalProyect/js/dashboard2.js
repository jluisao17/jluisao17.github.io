// Iniciar el odometro en todas las clases num
let valueDisplays = document.querySelectorAll('.num');

valueDisplays.forEach((valueDisplay) => {
    let endValue = parseInt(valueDisplay.getAttribute("data-val"));

    
    // Iniciar el odometro
    let odometer = new Odometer({
        el: valueDisplay,
        value: 0, // Valor inicial
        format: '(,ddd)', // Formar los números con comas
        theme: 'minimal', // Fondo minimalista
    });
    // Animar al valor final
        odometer.update(endValue);
        setInterval(() => {
            endValue += 100;
            odometer.update(endValue);
        }, 5000);
});