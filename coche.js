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
    let carouselIndicators = document.getElementById('carousel-indicators');
    let carouselInner = document.getElementById('carousel-inner');

    // Vaciamos los contenedores actuales
    carouselIndicators.innerHTML = '';
    carouselInner.innerHTML = '';

    // Generamos los nuevos elementos para los indicadores e imágenes del carrusel
    car.Imagenes.forEach((imagen, index) => {
        let indicator = document.createElement('button');
        indicator.setAttribute('type', 'button');
        indicator.setAttribute('data-bs-target', `#carCarousel${car.CarID}`);
        indicator.setAttribute('data-bs-slide-to', index);
        indicator.className = index === 0 ? 'active' : '';
        indicator.setAttribute('aria-current', index === 0 ? 'true' : '');
        indicator.setAttribute('aria-label', `Slide ${index + 1}`);
        carouselIndicators.appendChild(indicator);

        let carouselItem = document.createElement('div');
        carouselItem.className = `carousel-item ${index === 0 ? 'active' : ''}`;
        let img = document.createElement('img');
        img.className = 'd-block w-100 card-img-top';
        img.setAttribute('src', imagen);
        img.setAttribute('alt', `Imagen del coche ${index + 1}`);
        img.style.height = '16vh';
        img.style.objectFit = 'cover';
        carouselItem.appendChild(img);
        carouselInner.appendChild(carouselItem);
    });

    // Actualizaciones del resto de la información del coche
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