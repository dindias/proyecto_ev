<?php
session_start();
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
        footer {
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
    <div class="container">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCarModal">
            Añadir coche
        </button>
        <div class="row">
            <?php
            $cars = getUserCars($_SESSION['user_id']); // Obtiene los coches de la base de datos

            foreach($cars as $car){
                ?>
                <div class="card m-3" style="width: 18rem;" id="card<?php echo $car['CarID']; ?>">
                    <img class="card-img-top" src="<?php echo $car['imagenes']; ?>" alt="Card image cap" width="200px">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $car['Marca'] . " " . $car['Modelo']; ?></h5>
                        <p class="card-text">
                            ID: <?php echo $car['CarID']; ?><br>
                            Matricula: <?php echo $car['Matricula']; ?><br>
                            Año: <?php echo $car['Año']; ?><br>
                            Kilometraje: <?php echo $car['Kilometraje']; ?><br>
                            Descripción: <?php echo $car['Descripcion']; ?><br>
                            Precio: <?php echo $car['Precio']; ?>
                        </p>
                        <a href="#" class="btn btn-primary edit-btn" data-bs-toggle="modal" data-bs-target="#editCarModal" data-car-id="<?php echo $car['CarID']; ?>">Editar</a>
                        <button type="button" class="btn btn-primary deleteCarBtn" data-bs-toggle="modal" data-bs-target="#deleteCarModal" data-car-id="<?php echo $car['CarID']; ?>">Eliminar</button>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>

<!-- Modal Editar -->
<div class="modal fade" id="editCarModal" tabindex="-1" role="dialog" aria-labelledby="editCarModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar coche</h5>
                ...
            </div>
            <div class="modal-body">
                <input type="text" id="editMarca" placeholder="Marca"/>
                <input type="text" id="editModelo" placeholder="Modelo"/>
                <!-- Agrega aquí más inputs para las demás propiedades -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary saveChanges">Guardar cambios</button>
            </div>
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
                        <label for="ano" class="form-label">Año:</label>
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


<footer class="container-fluid text-center">
    <?php
    include ("footer.php");
    ?>
</footer>
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
    }

    //Modificación tabla usuarios

    //Adición coches
    $(document).ready(function() {
        $('#perfil form').on('submit', function(e) {
            e.preventDefault();

            // Recogemos los datos del formulario
            var formData = $(this).serializeArray();

            $.ajax({
                url: 'backend.php',
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('.container').html(response);
                }
            });
        });

        $("#addCarModal form").on("submit", function(e) {
            e.preventDefault();

            // Usamos FormData en lugar de serializeArray()
            var formData = new FormData(this);

            formData.append("action", "añadir_coche");

            $.ajax({
                url: 'backend.php',
                type: 'POST',
                data: formData,
                contentType: false, // Indica a jQuery que no establezca el tipo de contenido
                processData: false, // Impide que jQuery convierta los datos en una cadena de consulta
                success: function(response) {
                    $('.container').html(response);
                    $('#addCarModal').modal('hide');

                    // Añade este código
                    window.location.hash = "anuncios";
                }
            });
        });

        //Eliminación coches
        $(document).ready(function() {
            $('.deleteCarBtn').on('click', function(e) {
                e.preventDefault();

                var carID = $(this).attr('car-id');
                console.log(carID);

                $('#deleteCarModal .confirmDelete').data('car-id', carID); // Attach the car id data to the confirm button
            });

            $('#deleteCarModal .confirmDelete').on('click', function() {
                var carID = $(this).data('car-id');

                $.ajax({
                    type: 'POST',
                    url: 'backend.php',
                    data: {
                        action: 'eliminar_coche',
                        carID: carID
                    },
                    success: function(data) {
                        // Aquí puedes manejar qué sucede después de recibir una respuesta exitosa de tu archivo backend.php
                        console.log('Coche eliminado con éxito');
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        // Aquí puedes manejar qué sucede si ocurre un error durante la solicitud AJAX
                    }
                });
            });
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
