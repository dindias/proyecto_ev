
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
    return cars.map(car => `
        <div class="col-md-3 col-sm-6 col-xs-12 mb-4">
            <div class="card h-100 shadow" id="card${car.CarID}" style="border-radius: 15px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#detalles-coche" onclick="loadCarDetails(${JSON.stringify(car).split('"').join("&quot;")})">
                <div class="card-header" style="background-color: #f7f7f7; border-top-left-radius: 15px; border-top-right-radius: 15px;">
                    <h5 class="card-title text-wrap" style="color: #2575fc;"><b>${car.Marca} ${car.Modelo}</b></h5>
                </div>
                <img class="card-img-top" src="${car.imagenes}" alt="Card image cap" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                <div class="card-body">
                    <p class="card-text text-wrap">
                        <strong>Año:</strong> ${car.Ano}<br>
                        <strong>Kilometraje:</strong> ${car.Kilometraje}<br>
                        <strong>Descripción:</strong> ${car.Descripcion}<br>
                        <strong style="color: #28a745;">Precio:</strong> ${car.Precio}
                    </p>
                </div>
            </div>
        </div>
    `).join('');
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

let picker;
document.addEventListener('DOMContentLoaded', function () {
    picker = new Litepicker({
        element: document.getElementById('dateRangePicker'),
        singleMode: false,
        allowRepick: true,
        onSelect: function(start, end) {
            console.log(start, end);
        }
    });
});

function loadCarDetails(car) {
    // Actualizar el contenido del modal con los detalles del coche
    document.getElementById('carImage').src = car.imagenes;
    document.getElementById('carTitle').textContent = car.Marca + ' ' + car.Modelo;
    document.getElementById('carYear').textContent = `Año: ${car.Ano}`;
    document.getElementById('carMileage').textContent = `Kilometraje: ${car.Kilometraje}`;
    document.getElementById('carDescription').textContent = `Descripción: ${car.Descripcion}`;
    document.getElementById('carPrice').textContent = `Precio: ${car.Precio}`;

    // Abrir el modal con Bootstrap JavaScript API (asumiendo que usas Bootstrap 5)
    const modalElement = document.getElementById('detalles-coche');
    const modal = new bootstrap.Modal(modalElement);

    // Verificar si el modal se inicializó correctamente antes de abrirlo
    if (modal) {
        modal.show();

        // Agregar un evento de clic al botón "Siguiente" dentro del modal
        const btnSiguiente = modalElement.querySelector('#btnSiguiente');
        btnSiguiente.addEventListener('click', function () {
            console.log("estoy aquí");
            let carID = car.CarID;
            let startDate = picker.getStartDate().format('YYYY-MM-DD');
            let endDate = picker.getEndDate().format('YYYY-MM-DD');

            let formData = new FormData();
            formData.append('action', 'reservar_coche');
            formData.append('carID', carID);
            formData.append('startDate', startDate);
            formData.append('endDate', endDate);

            // Enviar los datos de carID, userID, startDate y endDate al servidor
            fetch('backend.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.text())
                .then(data => {
                    // Manejar la respuesta del servidor si es necesario
                    console.log(data);
                })
                .catch(error => {
                    // Manejar errores si es necesario
                    console.error(error);
                });
        });
    }
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