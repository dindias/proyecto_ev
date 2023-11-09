<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include("funciones_BD.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Panel de control</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        /* Add a gray background color and some padding to the footer */
        body{
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        /* Add a gray background color and some padding to the footer */
        footer {
            margin-top: auto;
            background-color: #f2f2f2;
            padding: 25px;
        }

    </style>
</head>
<body>

<header>
    <?php
    require ("header.php");
    ?>
</header>

<!-- Formulario login -->
<?php
include ("login.php");
?>

<!-- Formulario login -->
<?php
include ("register.php");
?>
<!-- Resto del body aquí -->

<ul class="nav nav-pills">
    <li class="nav-item">
        <a class="nav-link active" aria-current="page" id="perfilTab" href="#perfil" onclick="showTab('perfil'); return false;">Perfil</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="anunciosTab" href="#anuncios" onclick="showTab('anuncios'); return false;">Anuncios</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="historialTab" href="#historial" onclick="showTab('historial'); return false;">Historial</a>
    </li>
</ul>

<div id="perfil" class="tabContent">
    <div class="container">
        <h2>Actualizar Perfil</h2>
        <div class="col-lg-6 mx-auto">
        <form action="backend.php" method="post">
            <input type="hidden" name="action" value="modificar_perfil">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" id="nombre" placeholder="Introduce nuevo nombre" name="nombre">
            </div>

            <div class="mb-3">
                <label for="apellido" class="form-label">Apellido:</label>
                <input type="text" class="form-control" id="apellido" placeholder="Introduce nuevo apellido" name="apellido">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" placeholder="Introduce nuevo email" name="email">
            </div>

            <div class="mb-3">
                <label for="nacimiento" class="form-label">Nacimiento:</label>
                <input type="date" class="form-control" id="nacimiento" name="nacimiento">
            </div>

            <div class="mb-3">
                <label for="numeroCuenta" class="form-label">Número de cuenta:</label>
                <input type="text" class="form-control" id="numeroCuenta" placeholder="Introduce nuevo número de cuenta" name="numeroCuenta">
            </div>

            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección:</label>
                <input type="text" class="form-control" id="direccion" placeholder="Introduce nueva dirección" name="direccion">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña:</label>
                <input type="password" class="form-control" id="password" placeholder="Introduce nueva contraseña" name="password">
            </div>

            <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
        </div>
    </div>
</div>


<div id="anuncios" class="tabContent" style="display: none;">
    <div class="container"style="max-height: 100vh;">
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addCarModal">
            Añadir coche
        </button>
        <div class="input-group mb-3">
            <input type="text" class="form-control search-car" id="searchBar" placeholder="Buscar coche..." aria-label="Buscar coche" aria-describedby="button-search">
            <button class="btn btn-outline-secondary" type="button" id="button-search">Buscar</button>
        </div>
        <!-- Contenedor con barra de desplazamiento -->
        <div class="container-fluid" style="overflow-y: auto; max-height: 75vh;">
            <div class="d-flex flex-column align-items-stretch"> <!-- Asegurarse de estirar los elementos de la columna -->
                <?php
                $cars = getUserCars($_SESSION['user_id']); // Obtiene los coches de la base de datos

                foreach ($cars as $car) {
                    ?>
                    <!-- Tarjeta Horizontal -->
                    <div class="card mb-3" style="flex: 1;"> <!-- Removido max-width y añadido flex: 1 -->
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="<?php echo $car['imagenes']; ?>" class="img-fluid rounded-start" alt="Imagen del coche">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $car['Marca'] . " " . $car['Modelo']; ?></h5>
                                    <p class="card-text">
                                        ID: <?php echo $car['CarID']; ?><br>
                                        Matricula: <?php echo $car['Matricula']; ?><br>
                                        Año: <?php echo $car['Ano']; ?><br>
                                        Kilometraje: <?php echo $car['Kilometraje']; ?><br>
                                        Descripción: <?php echo $car['Descripcion']; ?><br>
                                        Precio: <?php echo $car['Precio']; ?>
                                    </p>
                                    <button type="button" class="btn btn-primary editCarBtn" data-bs-toggle="modal" data-bs-target="#editCarModal" data-car-id="<?php echo $car['CarID']; ?>">Editar</button>
                                    <button type="button" class="btn btn-primary deleteCarBtn" data-bs-toggle="modal" data-bs-target="#deleteCarModal" data-car-id="<?php echo $car['CarID']; ?>">Eliminar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Fin Tarjeta Horizontal -->
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>

<div id="historial" class="tabContent" style="display: none;">
    <div class="container" style="max-height: 100vh;">
        <!-- Contenedor con barra de desplazamiento -->
        <div class="container-fluid" style="overflow-y: auto; max-height: 75vh;">
            <div class="d-flex flex-column align-items-stretch"> <!-- Asegurarse de estirar los elementos de la columna -->
                <?php
                $reservas = getReservas($_SESSION['user_id']); // Obtiene las reservas del usuario
                foreach ($reservas as $reserva) {
                    ?>
                    <!-- Acordeón para cada reserva -->
                    <div class="accordion" id="reserva-<?php echo $reserva['ReservationID']; ?>">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading-<?php echo $reserva['ReservationID']; ?>">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $reserva['ReservationID']; ?>" aria-expanded="true" aria-controls="collapse-<?php echo $reserva['ReservationID']; ?>">
                                    <?php echo $reserva['Marca'] . " " . $reserva['Modelo']; ?>
                                </button>
                            </h2>
                            <div id="collapse-<?php echo $reserva['ReservationID']; ?>" class="accordion-collapse collapse show" aria-labelledby="heading-<?php echo $reserva['ReservationID']; ?>">
                                <div class="accordion-body">
                                    <!-- Mostrar detalles de la reserva, como FechaInicio, FechaFin y Observaciones -->
                                    Fecha de Inicio: <?php echo $reserva['FechaInicio']; ?><br>
                                    Fecha de Fin: <?php echo $reserva['FechaFin']; ?><br>
                                    Observaciones: <?php echo $reserva['Observaciones']; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Fin del acordeón -->
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar -->
<div class="modal fade" id="editCarModal" tabindex="-1" role="dialog" aria-labelledby="editCarModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="editCarForm">
                <div class="modal-header">
                    <h5 class="modal-title">Editar coche</h5>
                    <!-- ... resto del contenido del modal-header ... -->
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editMarca" class="form-label">Marca:</label>
                        <input type="text" id="editMarca" name="Marca" class="form-control" placeholder="Marca" required/>
                    </div>
                    <div class="mb-3">
                        <label for="editModelo" class="form-label">Modelo:</label>
                        <input type="text" id="editModelo" name="Modelo" class="form-control" placeholder="Modelo" required/>
                    </div>
                    <div class="mb-3">
                        <label for="editAno" class="form-label">Año:</label>
                        <input type="number" id="editAno" name="Ano" class="form-control" placeholder="Año" required min="1900" max="2099" step="1"/>
                    </div>
                    <div class="mb-3">
                        <label for="editMatricula" class="form-label">Matricula:</label>
                        <input type="text" id="editMatricula" name="Matricula" class="form-control" placeholder="Matricula" required/>
                    </div>
                    <div class="mb-3">
                        <label for="editKilometraje" class="form-label">Kilometraje:</label>
                        <input type="number" id="editKilometraje" name="Kilometraje" class="form-control" placeholder="Kilometraje" required/>
                    </div>
                    <div class="mb-3">
                        <label for="editDescripcion" class="form-label">Descripción:</label>
                        <input type="text" id="editDescripcion" name="Descripcion" class="form-control" placeholder="Descripcion"/>
                    </div>
                    <div class="mb-3">
                        <label for="editPrecio" class="form-label">Precio:</label>
                        <input type="number" id="editPrecio" name="Precio" class="form-control" placeholder="Precio" required/>
                    </div>
                    <div class="mb-3">
                        <label for="editImagen" class="form-label">Imagen:</label>
                        <input class="form-control" type="file" id="editImagen" name="imagen"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary saveChanges">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Eliminar -->
<div class="modal fade" id="deleteCarModal" tabindex="-1" role="dialog" aria-labelledby="deleteCarModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar coche</h5>
                ...
            </div>
            <div class="modal-body">
                ¿Estás seguro de que quieres eliminar este coche?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger confirmDelete">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<div id="historial" class="tabContent" style="display: none;">
    <!-- Aquí va el código para historial -->
</div>

<div class="modal fade" id="addCarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Añadir coche</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="backend.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="action" value="añadir_coche">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="marca" class="form-label">Marca:</label>
                        <input type="text" id="marca" name="Marca" class="form-control" placeholder="Marca" required/>
                    </div>
                    <div class="mb-3">
                        <label for="modelo" class="form-label">Modelo:</label>
                        <input type="text" id="modelo" name="Modelo" class="form-control" placeholder="Modelo" required/>
                    </div>
                    <div class="mb-3">
                        <label for="ano" class="form-label">Ano:</label>
                        <input type="number" id="ano" name="Ano" class="form-control" placeholder="Año" required min="1900" max="2099" step="1"/>
                    </div>
                    <div class="mb-3">
                        <label for="matricula" class="form-label">Matricula:</label>
                        <input type="text" id="matricula" name="Matricula" class="form-control" placeholder="Matricula" required/>
                    </div>
                    <div class="mb-3">
                        <label for="kilometraje" class="form-label">Kilometraje:</label>
                        <input type="number" id="kilometraje" name="Kilometraje" class="form-control" placeholder="Kilometraje" required/>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripcion:</label>
                        <input type="text" id="descripcion" name="Descripcion" class="form-control" placeholder="Descripcion"/>
                    </div>
                    <div class="mb-3">
                        <label for="precio" class="form-label">Precio:</label>
                        <input type="number" id="precio" name="Precio" class="form-control" placeholder="Precio" required/>
                    </div>
                    <div class="mb-3">
                        <label for="imagen" class="form-label">Imagen:</label>
                        <input class="form-control" type="file" id="imagen" name="imagen"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar coche</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php
include ("footer.php");
?>

<script>
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

        // Reemplaza $("#addCarModal form").on("submit", ...) con JS puro
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
                    document.querySelector('.container').innerHTML = response;
                    var addCarModal = bootstrap.Modal.getInstance(document.getElementById('addCarModal'));
                    addCarModal.hide();
                    window.location.hash = "anuncios";
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
                    // Caso donde el botón es de edición.

                    // Aquí deberás lógica para manejar la edición,
                    // por ejemplo, cargar los datos en el modal de edición o
                    // establecer atributos necesarios para la funcionalidad de edición.

                    // Ejemplo de cómo asignar el ID a un hipotético botón de guardar cambios en el modal de edición:
                    var saveChangesButton = document.querySelector('#editCarModal .saveChanges');
                    saveChangesButton.dataset.carId = carID; // Asigna el valor usando dataset también.
                }
            });
        });

        document.querySelector("#editCarModal .saveChanges").addEventListener("click", function(e) {
            e.preventDefault();
            console.log("estoy aquí");

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
            console.log("estoy aqui");
            const searchTerm = searchBar.value.toLowerCase();
            const cars = document.querySelectorAll('.card');

            cars.forEach(car => {
                const title = car.querySelector('.card-title').textContent.toLowerCase();
                car.style.display = title.includes(searchTerm) ? '' : 'none';
            });
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
