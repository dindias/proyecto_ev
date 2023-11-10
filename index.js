// js flecha de buscar más vehículos
var upInteractive = false;

function autoToggle() {
    // Esta función no cambia; seguirá alternando la clase 'auto' del elemento .arrow
    let arrow = document.querySelector('.arrow');
    arrow.classList.toggle('auto');
}

// Asociamos el evento mouseenter al elemento .card para activar la animación
document.querySelectorAll('.card').forEach(function(card) {
    card.addEventListener('mouseenter', function() {
        upInteractive = true;
        autoToggle(); // Activa la animación
    });
    card.addEventListener('mouseleave', function() {
        upInteractive = false;
        autoToggle(); // Restablece al estado original
    });
});

// El setInterval puede permanecer sin cambios o puedes removerlo si la animación solo se iniciará con el hover
setInterval(function(){
    if(upInteractive === false) {
        autoToggle();
    }
}, 2000);