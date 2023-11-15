<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include("funciones_BD.php");
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <title>Panel de control</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/305aef3688.js" crossorigin="anonymous"></script>
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

        .card-img {
            display: block;
            width: auto;
            height: 15vh;
            object-fit: cover;
        }
        .image-preview-thumbnail {
            max-width: 100px; /* O el tamaño que prefieras */
            max-height: 100px;
            object-fit: cover; /* Esto asegura que la imagen se recorte si no encaja, en lugar de deformarse */
        }

        .btn-toggle-favorito {
            color: #ffc107; /* Utilizamos un color amarillo similar al de una estrella */
            border-color: #ffc107;
        }
        .btn-toggle-favorito .fa {
            margin-right: 5px;
        }
        /* Cuando el coche es favorito, queremos un relleno sólido y un fondo amarillo */
        .btn-toggle-favorito[data-favorited="true"] {
            background-color: #ffc107;
            color: white; /* Cambiamos el texto a blanco para que resalte en fondo amarillo */
        }
        .btn-toggle-favorito[data-favorited="true"] .fa {
            color: white;
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
        <a class="nav-link" id="anunciosTab" href="#anuncios" onclick="showTab('anuncios'); return false;">Mis Anuncios</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="historialTab" href="#historial" onclick="showTab('historial'); return false;">Mis Reservas</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="favoritosTab" href="#favoritos" onclick="showTab('favoritos'); return false;">Mis Favoritos</a>
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
                    $carID = $car['CarID'];
                    $imagenes = $car['Imagenes']; // Este debe ser un array de imágenes
                    $numImages = count($imagenes);
                    ?>
                    <!-- Tarjeta Horizontal -->
                    <div class="card mb-3" style="flex: 1;"> <!-- Removido max-width y añadido flex: 1 -->
                        <div class="row g-0">
                            <div class="col-md-4">
                                <!-- Inicio del Carrusel -->
                                <div id="carousel<?php echo $carID; ?>" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        <?php foreach ($imagenes as $index => $imagen) { ?>
                                            <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                                <img src="<?php echo $imagen; ?>" class="d-block w-100 card-img" alt="...">
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <?php if ($numImages > 1) { ?>
                                        <button class="carousel-control-prev" type="button" data-bs-target="#carousel<?php echo $carID; ?>" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#carousel<?php echo $carID; ?>" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                        </button>
                                    <?php } ?>
                                </div>
                                <!-- Fin del Carrusel -->
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $car['Marca'] . " " . $car['Modelo']; ?></h5>
                                    <?php $encodedParams = json_encode(["CarID" => $carID, "Marca" => $car['Marca'], "Modelo" => $car['Modelo']]); ?>
                                    <button type="button" class="btn btn-primary viewCarBtn" onclick="redirectToCarDetails('<?php echo urlencode($encodedParams); ?>')">Ver anuncio</button>
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
                            <div id="collapse-<?php echo $reserva['ReservationID']; ?>" class="accordion-collapse collapse" aria-labelledby="heading-<?php echo $reserva['ReservationID']; ?>">
                                <div class="accordion-body">
                                    <!-- Mostrar detalles de la reserva, como FechaInicio, FechaFin y Observaciones -->
                                    Fecha de Inicio: <?php echo $reserva['FechaInicio']; ?><br>
                                    Fecha de Fin: <?php echo $reserva['FechaFin']; ?><br>
                                    Observaciones: <?php echo $reserva['Observaciones']; ?>
                                </div>
                                <button onclick="eliminarReserva(<?php echo $reserva['ReservationID']; ?>, <?php echo $reserva['UserID']; ?>)" class="btn btn-danger">Eliminar</button>
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

<div id="favoritos" class="tabContent" style="display: none;">
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
                $cars = getUserFavoriteCars($_SESSION['user_id']); // Obtiene los coches de la base de datos
                foreach ($cars as $car) {
                    $carID = $car['CarID'];
                    $imagenes = $car['Imagenes']; // Este debe ser un array de imágenes
                    $numImages = count($imagenes);
                    ?>
                    <!-- Tarjeta Horizontal -->
                    <div class="card mb-3" style="flex: 1;">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <!-- Inicio del Carrusel -->
                                <div id="carousel<?php echo $carID; ?>" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        <?php foreach ($imagenes as $index => $imagen) { ?>
                                            <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                                <img src="<?php echo $imagen; ?>" class="d-block w-100 card-img" alt="...">
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <?php if ($numImages > 1) { ?>
                                        <button class="carousel-control-prev" type="button" data-bs-target="#carousel<?php echo $carID; ?>" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#carousel<?php echo $carID; ?>" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                        </button>
                                    <?php } ?>
                                </div>
                                <!-- Fin del Carrusel -->
                            </div>
                            <div class="col-md-5">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $car['Marca'] . " " . $car['Modelo']; ?></h5>
                                    <p class="card-text">
                                        Año: <?php echo $car['Ano']; ?><br>
                                        Potencia: <?php echo $car['Potencia']; ?><br>
                                        Autonomia: <?php echo $car['Autonomia']; ?><br>
                                        Precio: <?php echo $car['Precio']; ?>€/día
                                    </p>
                                </div>
                            </div>
                            <div class="card-footer col-md-3">
                                <?php $encodedParams = json_encode(["CarID" => $carID, "Marca" => $car['Marca'], "Modelo" => $car['Modelo']]); ?>
                                <button type="button" class="btn btn-primary viewCarBtn" onclick="redirectToCarDetails('<?php echo urlencode($encodedParams); ?>')">Ver anuncio</button>
                                <button type="button" class="btn btn-toggle-favorito" onclick="toggleFavorito(this)" data-car-id="<?php echo $carID?>" data-favorited="false">
                                    <i class="fa fa-star-o"></i> Añadir a Favoritos
                                </button>
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

<!-- Modal Editar -->
<div class="modal fade" id="editCarModal" tabindex="-1" role="dialog" aria-labelledby="editCarModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="editCarForm">
                <input type="hidden" name="action" value="editar_coche">
                <input type="hidden" name="carID" id="editCarID" value="">
                <div class="modal-body py-3 mb-3">
                    <h2 class="h4 mb-4">Especificaciones</h2>
                    <div class="row">
                        <div>
                            <label for="imagenes" class="form-label">Imágenes:</label>
                            <input class="form-control" type="file" id="imagenes" name="imagenes[]" multiple/>
                        </div>
                        <div class="mb-2">
                            <label for="imagenPreview" class="form-label">Vista previa de imágenes:</label>
                            <div id="imagenPreview" class="mb-3"></div>
                        </div>
                        <div class="col-sm-6 col-md-12 col-lg-6">
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <label for="marca" class="form-label">Marca:</label>
                                    <input type="text" id="marca" name="Marca" class="form-control" placeholder="Marca" required/>
                                </li>
                                <li class="mb-2">
                                    <label for="modelo" class="form-label">Modelo:</label>
                                    <input type="text" id="modelo" name="Modelo" class="form-control" placeholder="Modelo" required/>
                                </li>
                                <li class="mb-2">
                                    <label for="ano" class="form-label">Año:</label>
                                    <input type="number" id="ano" name="Ano" class="form-control" placeholder="Año" required min="1900" max="2099" step="1"/>
                                </li>
                                <li>
                                    <label for="matricula" class="form-label">Matricula:</label>
                                    <input type="text" id="matricula" name="Matricula" class="form-control" placeholder="Matricula" required/>
                                </li>
                                <li class="mb-2">
                                    <label for="potencia" class="form-label">Potencia:</label>
                                    <input type="number" id="potencia" name="Potencia" class="form-control" placeholder="Potencia" required/>
                                </li>
                                <li class="mb-2">
                                    <label for="autonomia" class="form-label">Autonomía:</label>
                                    <input type="number" id="autonomia" name="Autonomia" class="form-control" placeholder="Autonomía" required/>
                                </li>
                            </ul>
                        </div>
                        <div class="col-sm-6 col-md-12 col-lg-6">
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <label for="kilometraje" class="form-label">Kilometraje:</label>
                                    <input type="number" id="kilometraje" name="Kilometraje" class="form-control" placeholder="Kilometraje" required/>
                                </li>
                                <li class="mb-2">
                                    <label for="motorizacion" class="form-label">Motorización:</label>
                                    <input type="text" id="motorizacion" name="Motorizacion" class="form-control" placeholder="Motorización" required/>
                                </li>
                                <li class="mb-2">
                                    <label for="contaminacion" class="form-label">Contaminación:</label>
                                    <input type="number" id="contaminacion" name="Contaminacion" class="form-control" placeholder="Contaminación" required/>
                                </li>
                                <li class="mb-2">
                                    <label for="precio" class="form-label">Precio:</label>
                                    <input type="number" id="precio" name="Precio" class="form-control" placeholder="Precio" required/>
                                </li>
                                <li class="mb-2">
                                    <label for="ubicacion" class="form-label">Ubicación:</label>
                                    <input type="text" id="ubicacion" name="Ubicacion" class="form-control" placeholder="Ubicación" required/>
                                </li>
                                <li class="mb-2">
                                    <label for="tipo" class="form-label">Tipo:</label>
                                    <select class="form-select" id="tipo" name="Tipo" required>
                                        <option value="Berlina">Berlina</option>
                                        <option value="Cabrio">Cabrio</option>
                                        <option value="Compacto">Compacto</option>
                                        <option value="Coupe">Coupé</option>
                                        <option value="Familiar">Familiar</option>
                                        <option value="Hibrido">Híbrido</option>
                                        <option value="Industrial">Industrial</option>
                                        <option value="Suv">Suv</option>
                                    </select>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-2">
                            <label for="descripcion" class="form-label">Descripción:</label>
                            <textarea id="descripcion" name="Descripcion" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <h2 class="h4 mb-4">Adiciones</h2>
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Exterior
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <label for="exterior" class="form-label">Exterior:</label>
                                        <textarea id="exterior" name="Exterior" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Interior
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <label for="interior" class="form-label">Interior:</label>
                                        <textarea id="interior" name="Interior" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        Seguridad
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <label for="seguridad" class="form-label">Seguridad:</label>
                                        <textarea id="seguridad" name="Seguridad" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingFour">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                        Tecnología
                                    </button>
                                </h2>
                                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <label for="tecnologia" class="form-label">Tecnología:</label>
                                        <textarea id="tecnologia" name="Tecnologia" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                <div class="modal-body py-3 mb-3">
                    <h2 class="h4 mb-4">Especificaciones</h2>
                    <div class="row">
                        <div>
                            <label for="imagenes" class="form-label">Imágenes:</label>
                            <input class="form-control" type="file" id="imagenes" name="imagenes[]" multiple/>
                        </div>
                        <div class="col-sm-6 col-md-12 col-lg-6">
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <label for="marca" class="form-label">Marca:</label>
                                    <input type="text" id="marca" name="Marca" class="form-control" placeholder="Marca" required/>
                                </li>
                                <li class="mb-2">
                                    <label for="modelo" class="form-label">Modelo:</label>
                                    <input type="text" id="modelo" name="Modelo" class="form-control" placeholder="Modelo" required/>
                                </li>
                                <li class="mb-2">
                                    <label for="ano" class="form-label">Ano:</label>
                                    <input type="number" id="ano" name="Ano" class="form-control" placeholder="Año" required min="1900" max="2099" step="1"/>
                                </li>
                                <li>
                                    <label for="matricula" class="form-label">Matricula:</label>
                                    <input type="text" id="matricula" name="Matricula" class="form-control" placeholder="Matricula" required/>
                                </li>
                                <li class="mb-2">
                                    <label for="potencia" class="form-label">Potencia:</label>
                                    <input type="number" id="potencia" name="Potencia" class="form-control" placeholder="Potencia" required/>
                                </li>
                                <li class="mb-2">
                                    <label for="autonomia" class="form-label">Autonomia:</label>
                                    <input type="number" id="autonomia" name="Autonomia" class="form-control" placeholder="Autonomia" required/>
                                </li>
                            </ul>
                        </div>
                        <div class="col-sm-6 col-md-12 col-lg-6">
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <label for="kilometraje" class="form-label">Kilometraje:</label>
                                    <input type="number" id="kilometraje" name="Kilometraje" class="form-control" placeholder="Kilometraje" required/>
                                </li>
                                <li class="mb-2">
                                    <label for="motorizacion" class="form-label">Motorizacion:</label>
                                    <input type="text" id="motorizacion" name="Motorizacion" class="form-control" placeholder="Motorizacion" required/>
                                </li>
                                <li class="mb-2">
                                    <label for="contaminacion" class="form-label">Contaminacion:</label>
                                    <input type="number" id="contaminacion" name="Contaminacion" class="form-control" placeholder="Contaminacion" required/>
                                </li>
                                <li class="mb-2">
                                    <label for="precio" class="form-label">Precio:</label>
                                    <input type="number" id="precio" name="Precio" class="form-control" placeholder="Precio" required/>
                                </li>
                                <li class="mb-2">
                                    <label for="ubicacion" class="form-label">Ubicacion:</label>
                                    <input type="text" id="ubicacion" name="Ubicacion" class="form-control" placeholder="Ubicacion" required/>
                                </li>
                                <li class="mb-2">
                                    <label for="tipo" class="form-label">Tipo:</label>
                                    <select class="form-select" id="tipo" name="Tipo" required>
                                        <option value="Berlina">Berlina</option>
                                        <option value="Cabrio">Cabrio</option>
                                        <option value="Compacto">Compacto</option>
                                        <option value="Coupe">Coupé</option>
                                        <option value="Familiar">Familiar</option>
                                        <option value="Hibrido">Híbrido</option>
                                        <option value="Industrial">Industrial</option>
                                        <option value="Suv">Suv</option>
                                    </select>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <label for="descripcion" class="col-form-label">Descripcion:</label>
                        <textarea id="descripcion" name="Descripcion" class="form-control"></textarea>
                    </div><br>
                    <div class="row">
                        <h2 class="h4 mb-4">Adiciones</h2>
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Exterior
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <label for="exterior" class="form-label">Exterior:</label>
                                        <textarea id="exterior" name="Exterior" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Interior
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <label for="interior" class="form-label">Interior:</label>
                                        <textarea id="interior" name="Interior" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        Seguridad
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <label for="seguridad" class="form-label">Seguridad:</label>
                                        <textarea id="seguridad" name="Seguridad" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingFour">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                        Tecnologia
                                    </button>
                                </h2>
                                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <label for="tecnologia" class="form-label">Tecnologia:</label>
                                        <textarea id="tecnologia" name="Tecnologia" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
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
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
