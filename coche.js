var picker;
document.addEventListener('DOMContentLoaded', function () {
    const carID = document.getElementById('dateRangePicker').dataset.carId;

    function fetchReservedDates(callback) {
        let formData = new FormData();
        formData.append('action', 'checkFecha');
        formData.append('carID', carID);
        fetch('backend.php', {
            method: 'POST',
            body: formData
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                callback(data);
            })
            .catch(error => console.error('Error al obtener las fechas reservadas:', error));
    }

    function initializeLitepicker(datesToLock) {
        const today = new Date();
        today.setHours(0, 0, 0, 0); // Establece la hora a medianoche para asegurarse de que hoy no esté bloqueado.

        console.log("estoy aqui");
        picker = new Litepicker({
            element: document.getElementById('dateRangePicker'),
            minDate: today,
            singleMode: false,
            allowRepick: true,
            lockDays: datesToLock,
            disallowLockDaysInRange: true,
            lockDaysFormat: 'YYYY-MM-DD'
        });
        // Enganchando el evento 'preselect' después de haber inicializado picker
        picker.on('preselect', function(date1, date2) {
            const precioElement = document.getElementById('precioValor');
            const precioBase = parseFloat(document.getElementById('precioTotal').dataset.precioBase);
            const diffTime = Math.abs(date2.getTime() - date1.getTime());
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1; // +1 para incluir tanto el día de inicio como el de fin
            const precioTotal = precioBase * diffDays;

            precioElement.textContent = precioTotal.toFixed(2);
        });
    }

    fetchReservedDates(function(reservedDates) {
        const datesToLock = reservedDates.map(date => {
            if (date.FechaInicio === date.FechaFin) {
                return date.FechaInicio;
            }
            return [ date.FechaInicio, date.FechaFin ];
        });

        initializeLitepicker(datesToLock);
    });
});

function loadCarDetails(car) {

    // Abrir el modal con Bootstrap JavaScript API (asumiendo que usas Bootstrap 5)
    const modalElement = document.getElementById('comprarModal');
    const modal = new bootstrap.Modal(modalElement);

    // Verificar si el modal se inicializó correctamente antes de abrirlo
    if (modal) {
        modal.show();

        // Agregar un evento de clic al botón "Siguiente" dentro del modal
        const btnSiguiente = modalElement.querySelector('.btn-siguiente');
        btnSiguiente.addEventListener('click', function () {
            let carID = car;
            let startDate = picker.getStartDate().format('YYYY-MM-DD');
            let endDate = picker.getEndDate().format('YYYY-MM-DD');
            let precioTotal = document.getElementById('precioValor').textContent;

            let formData = new FormData();
            formData.append('action', 'reservar_coche');
            formData.append('carID', carID);
            formData.append('startDate', startDate);
            formData.append('endDate', endDate);
            formData.append('precioTotal', precioTotal);

            // Enviar los datos de carID, userID, startDate y endDate al servidor
            fetch('backend.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.text())
                .then(data => {
                    // Manejar la respuesta del servidor si es necesario
                    console.log(data);
                    window.location.href = 'control_panel.php#historial';
                })
                .catch(error => {
                    // Manejar errores si es necesario
                    console.error(error);
                });
        });
    }
}

var modalElement = document.getElementById('comprarModal');

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



document.addEventListener('DOMContentLoaded', function() {
    const button = document.querySelector('.btn-toggle-favorito'); // El selector debe apuntar al botón correcto
    if (button) {
        checkIfFavorited(button);
    }
});

async function checkIfFavorited(button) {
    const carID = button.getAttribute('data-car-id');
    let formData = new FormData();
    formData.append('action', 'esFavorito');
    formData.append('carID', carID);

    try {
        const response = await fetch('backend.php', {
            method: 'POST',
            body: formData
        });
        if (!response.ok) {
            throw new Error('No se pudo obtener una respuesta válida del servidor.');
        }
        const data = await response.json();
        if (data.success) {
            updateFavoriteButton(button, data.isFavorito);
        } else {
            throw new Error(data.message || 'Error desconocido al verificar favorito.');
        }
    } catch (error) {
        console.error('Error al verificar si es favorito:', error);
    }
}

async function toggleFavorito(button) {
    const carID = button.getAttribute('data-car-id');
    const isFavorited = button.getAttribute('data-favorited') === 'true';
    let formData = new FormData();
    formData.append('carID', carID);

    // Decidir qué acción tomar, agregar o eliminar favorito
    const action = isFavorited ? 'eliminarFavorito' : 'agregarFavorito';
    formData.append('action', action);

    try {
        const response = await fetch('backend.php', {
            method: 'POST',
            body: formData
        });
        if (!response.ok) {
            throw new Error('Respuesta de red no fue ok.');
        }
        const data = await response.json(); // Asume que el servidor devuelve una respuesta JSON
        console.log(data);

        // Manejar la respuesta del servidor
        if (data.success) {
            const newFavoritedState = !isFavorited;
            button.setAttribute('data-favorited', newFavoritedState);

            const iconClass = newFavoritedState ? 'fa fa-star' : 'fa fa-star-o';
            const actionText = newFavoritedState ? 'Eliminar de Favoritos' : 'Añadir a Favoritos';
            button.innerHTML = `<i class="${iconClass}"></i> ${actionText}`;
            button.classList.toggle('btn-primary', newFavoritedState);
            button.classList.toggle('btn-outline-primary', !newFavoritedState);
        } else {
            throw new Error(data.message);
        }
    } catch (error) {
        alert(error.message);
        console.error('Error al togglear favorito:', error);
    }
}

function updateFavoriteButton(button, isFavorited) {
    button.setAttribute('data-favorited', isFavorited);
    const action = isFavorited ? 'Eliminar de Favoritos' : 'Añadir a Favoritos';

    button.innerHTML = `<i class="fa ${isFavorited ? 'fa-star' : 'fa-star-o'}"></i> ${action}`;
}
