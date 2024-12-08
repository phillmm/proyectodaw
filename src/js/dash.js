//SLIDER DE INDEX
let currentIndex = 0;
const items = document.querySelectorAll('.elemento-hero');
const totalItems = items.length;

function showNextItem() {
    currentIndex = (currentIndex + 1) % totalItems; // Incrementar el índice y reiniciar si es necesario
    const offset = -currentIndex * 100; // Calcular el desplazamiento
    document.querySelector('.slider-container').style.transform = `translateX(${offset}%)`; // Aplicar el desplazamiento
}

// Iniciar el slider
setInterval(showNextItem, 3000); // Cambiar cada 3 segundos