
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

function redirectToCarDetails(carParams) {
    const decodedParams = JSON.parse(decodeURIComponent(carParams));
    const carID = decodedParams.CarID;
    const marca = decodedParams.Marca;
    const modelo = decodedParams.Modelo;
    window.location.href = `coche.php?CarID=${carID}&Marca=${marca}&Modelo=${modelo}`;
}

//Mostrar ventanas panel de control
function showTab(tabId) {
    // Oculta todas las pestañas primero
    var tabs = document.getElementsByClassName('tabContent');
    for (var i = 0; i < tabs.length; i++) {
        tabs[i].style.display = 'none';
    }

    // Muestra la pestaña seleccionada
    document.getElementById(tabId).style.display = 'block';

    // Obtén todos los elementos li
    var liTabs = document.querySelectorAll(".nav .nav-item");
    // Recorre cada elemento li y elimina la clase active
    for (var i = 0; i < liTabs.length; i++) {
        liTabs[i].firstElementChild.classList.remove("active");
    }

    // Añade la clase active al tab actual (el que ha sido seleccionado)
    var activeTab = document.querySelector(".nav a[href='#" + tabId + "']");
    activeTab.classList.add("active");

    // Actualiza el hash en la URL sin recargar la página
    window.location.hash = tabId;
}

function showTabFromHash() {
    var hash = window.location.hash.replace('#', '');
    if (hash) {
        showTab(hash);
    }
}

document.addEventListener('DOMContentLoaded', showTabFromHash);
// Controlador para cambiar de pestaña cuando el hash de la URL cambia
window.addEventListener('hashchange', showTabFromHash);
//Modificación tabla usuarios

document.addEventListener('DOMContentLoaded', function() {
    // Reemplaza $('#perfil form').on('submit', ...) con una versión en JS puro
    document.querySelector('#perfil form').addEventListener('submit', function(e) {
        e.preventDefault();

        // Prepara el objeto FormData
        var formData = new FormData(this);

        fetch('backend.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.text())
            .then(response => {
                window.location.reload();
            });
    });

    document.querySelector("#addCarModal form").addEventListener("submit", function(e) {
        e.preventDefault();

        // Prepara el objeto FormData y agrega el campo 'action'
        var formData = new FormData(this);
        formData.append("action", "añadir_coche");

        fetch('backend.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.text())
            .then(response => {
                console.log('Coche añadido con éxito');
                var addCar = bootstrap.Modal.getInstance(document.getElementById('addCarModal'));
                addCar.hide();
            });
    });

    var carButtons = document.querySelectorAll('.editCarBtn, .deleteCarBtn');

    carButtons.forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();

            // Obtiene el ID del coche usando dataset.
            var carID = this.dataset.carId; // 'carId' en camelCase corresponde a 'data-car-id'
            console.log(carID);

            if (this.classList.contains('deleteCarBtn')) {
                // Caso donde el botón es de eliminación.

                // Adjunta el ID del coche al botón de confirmación en el modal de eliminación.
                var confirmDeleteButton = document.querySelector('#deleteCarModal .confirmDelete');
                confirmDeleteButton.dataset.carId = carID; // Asigna el valor usando dataset también.

            } else if (this.classList.contains('editCarBtn')) {
                var carID = this.dataset.carId;

                var formData = new FormData();
                formData.append("carID", carID);
                formData.append("action", "recoger_coche");

                var request = new XMLHttpRequest();
                request.open('POST', 'backend.php', true);
                request.responseType = 'json';

                request.onload = function() {
                    if (this.status >= 200 && this.status < 400) {
                        // Exito!
                        var carDetails = this.response;

                        document.getElementById('marca').value = carDetails[0].Marca;
                        document.getElementById('modelo').value = carDetails[0].Modelo;
                        document.getElementById('ano').value = carDetails[0].Ano;
                        document.getElementById('matricula').value = carDetails[0].Matricula;
                        document.getElementById('potencia').value = carDetails[0].Potencia;
                        document.getElementById('autonomia').value = carDetails[0].Autonomia;
                        document.getElementById('kilometraje').value = carDetails[0].Kilometraje;
                        document.getElementById('motorizacion').value = carDetails[0].Motorizacion;
                        document.getElementById('contaminacion').value = carDetails[0].Contaminacion;
                        document.getElementById('precio').value = carDetails[0].Precio;
                        document.getElementById('tipo').value = carDetails[0].Tipo;
                        document.getElementById('descripcion').value = carDetails[0].Descripcion;
                        document.getElementById('exterior').value = carDetails[0].Exterior;
                        document.getElementById('interior').value = carDetails[0].Interior;
                        document.getElementById('seguridad').value = carDetails[0].Seguridad;
                        document.getElementById('tecnologia').value = carDetails[0].Tecnologia;

                        // Muestra las imágenes en el modal.
                        var imagenPreview = document.getElementById('imagenPreview');
                        imagenPreview.innerHTML = ""; // Limpiamos el contenido previo

                        carDetails[0].Imagenes.forEach(function(imagen) {
                            var imgElement = document.createElement('img');
                            imgElement.src = imagen;  // Asegúrate de que el src es correcto. Puede que necesites ajustar la ruta
                            imgElement.classList.add('image-preview-thumbnail', 'img-thumbnail', 'm-1');
                            imagenPreview.appendChild(imgElement);
                        });

                        // Asigna el ID del coche al botón de guardar cambios.
                        var saveChangesButton = document.querySelector('#editCarModal .saveChanges');
                        saveChangesButton.dataset.carId = carID;
                    } else {
                        // Alcanzamos nuestro servidor objetivo, pero devolvió un error
                        console.error('Error del servidor: ', this.status);
                    }
                };

                request.onerror = function() {
                    // Hubo un error de conexión de algún tipo
                    console.error('Error de conexión');
                };

                request.send(formData);
            }

        });
    });

    document.querySelector("#editCarModal .saveChanges").addEventListener("click", function(e) {
        e.preventDefault();

        // Selecciona el formulario
        var form = document.querySelector("#editCarForm");

        // Verifica si el formulario existe antes de intentar crear el objeto FormData
        if(form){
            // El objeto FormData se construye a partir del formulario en el modal de edición
            var formData = new FormData(form); // Pasa el formulario en lugar de 'this'
            formData.append("action", "editar_coche"); // Acción para el backend

            fetch('backend.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.text())
                .then(data => {
                    console.log('Coche editado con éxito');
                    var editModal = bootstrap.Modal.getInstance(document.getElementById('editCarModal'));
                    editModal.hide();
                })
                .catch(error => {
                    console.error('Error al intentar editar el coche', error);
                });
        } else {
            console.error('No se encontró el formulario para editar el coche');
        }
    });

    // Para el botón de confirmación del borrado
    document.querySelector('#deleteCarModal .confirmDelete').addEventListener('click', function() {
        var carID = this.getAttribute('data-car-id');
        var formData = new FormData();
        formData.append('action', 'eliminar_coche');
        formData.append('carID', carID);

        fetch('backend.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.text())
            .then(data => {
                console.log('Coche eliminado con éxito');
                var deleteModal = bootstrap.Modal.getInstance(document.getElementById('deleteCarModal'));
                deleteModal.hide();
            })
            .catch(error => {
                console.error(error);
            });
    });

    const searchBar = document.getElementById('searchBar');

    searchBar.addEventListener('input', () => {
        const searchTerm = searchBar.value.toLowerCase();
        const cars = document.querySelectorAll('.card');

        cars.forEach(car => {
            const title = car.querySelector('.card-title').textContent.toLowerCase();
            car.style.display = title.includes(searchTerm) ? '' : 'none';
        });
    });
});

function eliminarReserva(reservationID, UserID) {
    // Confirmar que el usuario realmente quiere eliminar la reserva
    if (!confirm("¿Estás seguro que deseas eliminar esta reserva?")) {
        return;
    }

    var formData = new FormData();
    formData.append('action', 'eliminar_reserva');
    formData.append('reservationID', reservationID);
    formData.append('UserID', UserID);

    fetch('backend.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                // Eliminamos el div que contiene la reserva
                document.getElementById(`reserva-${reservationID}`).remove();
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

document.addEventListener('DOMContentLoaded', function () {
    // Obtener la fecha actual en formato DateTime
    const now = new Date();

    // Obtener todas las tarjetas de reservas
    const tarjetasReserva = document.querySelectorAll('.reservas');

    // Iterar sobre cada tarjeta de reserva
    tarjetasReserva.forEach(tarjeta => {
        // Obtener la fecha de inicio y fin de la tarjeta en formato DateTime
        const fechaInicio = new Date(tarjeta.dataset.fechaInicio);
        const fechaFin = new Date(tarjeta.dataset.fechaFin);

        // Calcular la diferencia en horas entre la fecha actual y la fecha de inicio
        const diferenciaHoras = Math.abs(fechaInicio - now) / 36e5;

        // Determinar si el botón de eliminar debe mostrarse o no (menos de 48 horas)
        const mostrarEliminar = diferenciaHoras >= 48;

        // Determinar si la tarjeta está vencida (fecha de fin ha pasado)
        const tarjetaVencida = now > fechaFin;

        // Aplicar clases de Bootstrap según las condiciones
        tarjeta.classList.toggle('bg-secondary', tarjetaVencida);

        // Obtener el elemento del botón de eliminar dentro de la tarjeta
        const btnEliminar = tarjeta.querySelector('.eliminarReserva');

        // Mostrar u ocultar el botón de eliminar según la condición
        btnEliminar.style.display = mostrarEliminar ? 'block' : 'none';
    });
});

document.addEventListener('DOMContentLoaded', function () {
    let userID = document.getElementById('notificacionesAccordion').dataset.userId;

// Llamada a la función para obtener notificaciones
    getNotifications(userID);

    function getNotifications(userID) {
        let formData = new FormData();
        formData.append('action', 'getNotificaciones');
        formData.append('userID', userID);
        fetch('backend.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                // Construir la tabla de notificaciones
                data.sort((a, b) => new Date(b.CreatedAt) - new Date(a.CreatedAt));
                buildNotificationsTable(data);
            })
            .catch(error => {
                console.error('Error al obtener notificaciones:', error);
            });
    }

    function buildNotificationsTable(notifications) {
        var accordionDiv = document.getElementById('notificacionesAccordion');

        notifications.forEach((notification, index) => {
            // Crear un elemento de acordeón para cada notificación
            var accordionItem = document.createElement('div');
            accordionItem.classList.add('accordion-item');

            // Aplicar clase para notificaciones leídas
            if (notification.IsRead === 1) {
                accordionItem.classList.add('notificacion-leida');
            }

            // Crear el encabezado del elemento de acordeón
            var accordionHeader = document.createElement('h2');
            accordionHeader.classList.add('accordion-header');
            accordionHeader.setAttribute('id', 'heading' + index);

            // Crear el botón de acordeón
            var btn = document.createElement('button');
            btn.classList.add('accordion-button');
            btn.setAttribute('type', 'button');
            btn.setAttribute('data-bs-toggle', 'collapse');
            btn.setAttribute('data-bs-target', '#collapse' + index);
            btn.setAttribute('aria-expanded', 'false');
            btn.setAttribute('aria-controls', 'collapse' + index);
            btn.innerHTML = `Notificación recibida el ${notification.CreatedAt}`;

            // Agregar el botón al encabezado
            accordionHeader.appendChild(btn);

            // Agregar el encabezado al elemento de acordeón
            accordionItem.appendChild(accordionHeader);

            // Crear el cuerpo del elemento de acordeón (contenido colapsable)
            var collapseDiv = document.createElement('div');
            collapseDiv.classList.add('accordion-collapse', 'collapse');
            collapseDiv.setAttribute('id', 'collapse' + index);
            collapseDiv.setAttribute('aria-labelledby', 'heading' + index);
            collapseDiv.setAttribute('data-bs-parent', '#notificacionesAccordion');

            // Crear el cuerpo del elemento de acordeón con el mensaje
            var accordionBody = document.createElement('div');
            accordionBody.classList.add('accordion-body');
            accordionBody.innerHTML = `<strong>Mensaje:</strong> ${notification.Message}`;

            // Agregar el cuerpo al elemento de acordeón
            collapseDiv.appendChild(accordionBody);

            // Agregar el cuerpo al elemento de acordeón
            accordionItem.appendChild(collapseDiv);

            // Agregar el elemento de acordeón al contenedor
            accordionDiv.appendChild(accordionItem);

            btn.addEventListener('click', function () {
                markNotificationAsRead(notification.NotificationID);
            });
        });
    }
});

function markNotificationAsRead(notificationID) {
    let markNotificationFormData = new FormData();
    markNotificationFormData.append('action', 'markNotification');
    markNotificationFormData.append('notificationID', notificationID);

    fetch('backend.php', {
        method: 'POST',
        body: markNotificationFormData
    })
        .then(markResponse => markResponse.json())
        .then(markData => {
            // Puedes realizar acciones adicionales después de marcar la notificación como leída, si es necesario.
        })
        .catch(markError => {
            console.error('Error al marcar notificación como leída:', markError);
        });
}
