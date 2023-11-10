// Event listener que se dispara cuando se carga el contenido de la página
document.querySelectorAll('.filtro-tipo').forEach(function(card) {
    card.addEventListener('click', function() {
        sessionStorage.setItem('tipo', card.dataset.tipo);
        window.location.href = 'busqueda.php'; // Redirecciona a busqueda.php
    });
});

// Envía una solicitud POST a busqueda.php con el filtro de tipo
function sendPostRequestWithFilters(tipo) {
    let formData = new FormData();
    formData.append('tipo', tipo); // Establece el filtro de tipo
    fetch('busqueda.php', {
        method: 'POST',
        body: formData
    })
        .then(response => {
            // Manejar la respuesta. Por ejemplo, puedes redirigir al usuario si busqueda.php devuelve una URL.
            return response.text();
        })
        .then(html => {
            // Si busqueda.php devuelve el contenido HTML de la página de result
            // puedes asignar directamente ese HTML al documento actual o usarlo como sea necesario.
            document.write(html);
            document.close();
        })
        .catch(error => console.error('Hubo un error al enviar el filtro:', error));
}

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