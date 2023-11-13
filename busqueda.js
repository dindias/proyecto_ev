console.log("estoy aquí");
function applyInitialFilters() {
    // Suponiendo que la información del filtro viene en el cuerpo de la
    // solicitud POST, por ejemplo, como FormData que se envió desde index.php
    // Esta función puede ser llamada en el evento 'DOMContentLoaded'

    // Verifica si se han pasado los datos del filtro a través de la sesión o algún otro medio
    if (sessionStorage.getItem('tipo') !== null) {
        // Suponemos que el filtro de tipo se almacena en sessionStorage
        const tipo = sessionStorage.getItem('tipo');
        sessionStorage.removeItem('tipo'); // Limpia el valor para futuras cargas

        // Si es necesario aplicar más filtros, puedes extender este código para manejar esos casos

        // Activa los checkboxes según el filtro inicial
        document.querySelectorAll('.filtro .form-check-input').forEach(checkBox => {
            if (checkBox.value === tipo) {
                checkBox.checked = true;
            }
        });

        // Podemos llamar directamente a loadCars o establecer un breve retraso si es necesario
        setTimeout(() => loadCars(1), 100); // Ejecuta con un pequeño retraso para dar tiempo a actualizaciones visuales
    }
}

document.addEventListener('DOMContentLoaded', function() {
    applyInitialFilters(); // Aplica los filtros iniciales si es que los hay
    loadCars(1); // Luego ejecuta la carga inicial de coches
});


document.querySelectorAll('.filtro .form-check-input').forEach(function(checkbox) {
    checkbox.addEventListener('change', onFilterChanged);
});

function onFilterChanged(event) {
    loadCars(1); // Recargar la página 1 con los filtros actualizados
}
document.addEventListener('DOMContentLoaded', function() {
    loadCars(1); // Carga inicial de coches
});

function loadCars(page) {
    let formData = new FormData();
    formData.append('page', page);
    formData.append('action', 'paginate_cars');

    // Recoger los valores de los checkboxes de filtros actuales que están marcados
    document.querySelectorAll('.filtro .form-check-input:checked').forEach(checkBox => {
        const key = checkBox.closest('.filtro').getAttribute('data-filtro');
        formData.append(key + '[]', checkBox.value); // Agregar cada checkbox como elemento de un array
    });

    fetch('backend.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            document.getElementById('cars-container').innerHTML = generateCarsHTML(data.cars);
            updatePagination(data.totalPages, page);
        })
        .catch(error => console.error('Hubo un error al cargar los coches:', error));
}

function generateCarsHTML(cars) {
    return cars.map(car => { // Añadimos llaves aquí para empezar el bloque de la función
        const carSlug = slugify(car.Marca) + '-' + slugify(car.Modelo) + '-' + car.CarID;
        return `
            <div class="col-md-3 col-sm-6 col-xs-12 mb-4">
                <div class="card h-100 shadow" id="card${car.CarID}" style="border-radius: 15px; cursor: pointer;">
                    <div id="carCarousel${car.CarID}" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            ${car.Imagenes.map((image, index) => `
                                <div class="carousel-item ${index === 0 ? 'active' : ''}">
                                    <img src="${image}" class="d-block w-100 card-img-top" alt="Imagen del coche" style="height: 16vh; object-fit: cover;">
                                </div>
                            `).join('')}
                        </div>
                        ${car.Imagenes.length > 1 ? `
                        <a class="carousel-control-prev" href="#carCarousel${car.CarID}" role="button" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        </a>
                        <a class="carousel-control-next" href="#carCarousel${car.CarID}" role="button" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        </a>
                        ` : ''}
                    </div>
                    <div class="card-body" onclick="window.location.href='coche/${carSlug}'"> <!-- Usamos carSlug aquí -->
                        <p class="card-text text-wrap">
                            <strong>Año:</strong> ${car.Ano}<br>
                            <strong>Potencia:</strong> ${car.Potencia}<br>
                            <strong>Autonomia:</strong> ${car.Autonomia}<br>
                            <strong>Descripción:</strong> ${car.Descripcion}<br>
                            <strong style="color: #28a745;">Precio:</strong> ${car.Precio}
                        </p>
                    </div>
                </div>
            </div>
        `;
    }).join(''); // Añadimos un join al final para convertir el arreglo en un único string
}

function slugify(text) {
    return text.toString().toLowerCase()
        .replace(/\s+/g, '-')           // Replace spaces with -
        .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
        .replace(/\-\-+/g, '-')         // Replace multiple - with single -
        .replace(/^-+/, '')             // Trim - from start of text
        .replace(/-+$/, '');            // Trim - from end of text
}

var modalElement = document.getElementById('detalles-coche');

if (modalElement) {
    modalElement.addEventListener('hidden.bs.modal', function () {
        // Comprueba si el cuerpo tiene la clase 'modal-open' y la elimina
        document.body.classList.remove('modal-open');

        // Elimina las propiedades 'overflow' y 'padding-right' estilo directamente en el body, si existen
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';

        // Elimina el modal backdrop si existe
        var backdrops = document.querySelectorAll('.modal-backdrop');
        backdrops.forEach(function(backdrop) {
            backdrop.remove();
        });
    });
}


function updatePagination(totalPages, currentPage) {
    let paginationHTML = '';
    for (let i = 1; i <= totalPages; i++) {
        paginationHTML += `<li class="page-item ${currentPage == i ? 'active' : ''}">
        <a class="page-link" href="#" onclick="loadCars(${i}); return false;">${i}</a>
    </li>`;
    }
    document.getElementById('pagination').innerHTML = paginationHTML;
}

function onFilterItemSelected(event) {
    event.preventDefault(); // Esto previene el comportamiento por defecto del enlace, que es navegar hacia el "#".

    // Asegúrate de que el evento sea manejado solo si se desencadena en elementos esperados
    if (!event.target.matches('.dropdown-item')) {
        return;
    }

    const filtroElem = event.target.closest('.filtro');
    const filtroValue = event.target.textContent.trim(); // Usar trim() para eliminar espacios en blanco

    // Procede solo si filtroElem no es null.
    if (filtroElem) {
        // Restablecer todos los filtros si se selecciona 'Sin filtro' o aplicar el filtro seleccionado
        if (filtroElem) {
            // Restablecer todos los filtros si se selecciona 'Sin filtro'
            if (filtroValue === 'Sin filtro') {
                delete filtroElem.dataset.value; // Elimina la propiedad value del dataset, en lugar de asignarle null
            } else {
                filtroElem.dataset.value = filtroValue;
            }

            loadCars(1); // Cargar los coches aplicando los filtros actuales
        } else {
            // Manejo de errores o registro opcional para situaciones inesperadas
            console.error('onFilterItemSelected: filtroElem is null');
        }
    }
}

// Asegúrate de que cada elemento que actúa como un filtro llame a esta función en su evento de clic
document.querySelectorAll('.filtro .dropdown-item').forEach(function(item) {
    item.addEventListener('click', onFilterItemSelected);
});