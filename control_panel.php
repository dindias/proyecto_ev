<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    // Redirigir a la página de inicio de sesión o cualquier otra página
    header('Location: index.php');
    exit();
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
    <link rel="stylesheet" href="control_panel.css">
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

<div class="container-flex" style="min-height: 1080px">
    <div class="row">
        <div class="col-md-2 opciones">
            <nav id="sidebar" class="navbar navbar-expand-lg d-flex justify-content-center align-items-center">
                <button class="navbar-toggler w-100 bg-primary" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarCollapse" aria-controls="sidebarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa-solid fa-user-gear"></i>
                </button>
                <div class="collapse navbar-collapse" id="sidebarCollapse">
                    <ul class="nav flex-column nav-pills">
                        <li class="nav-item text-center">
                            <a class="nav-link active" aria-current="page" id="perfilTab" href="#perfil" onclick="showTab('perfil'); return false;">Perfil</a>
                        </li>
                        <li class="nav-item text-center">
                            <a class="nav-link" id="notificacionesTab" href="#notificaciones" onclick="showTab('notificaciones'); return false;">Notificaciones</a>
                        </li>
                        <li class="nav-item text-center">
                            <a class="nav-link" id="anunciosTab" href="#anuncios" onclick="showTab('anuncios'); return false;">Anuncios</a>
                        </li>
                        <li class="nav-item text-center">
                            <a class="nav-link" id="historialTab" href="#historial" onclick="showTab('historial'); return false;">Reservas</a>
                        </li>
                        <li class="nav-item text-center">
                            <a class="nav-link" id="favoritosTab" href="#favoritos" onclick="showTab('favoritos'); return false;">Favoritos</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="col-md-8 opciones" style="margin: 10px;">
            <div id="perfil" class="tabContent" style="height: 100%">
                <div class="container">
                    <h2 class="mb-4">Tus datos</h2>
                    <div class="row">
                        <?php
                        // Obtén los datos del usuario
                        $userData = getYourData($_SESSION['user_id']);

                        // Verifica si se obtuvieron datos
                        if ($userData) {
                            ?>
                            <div class="col-md-4">
                                <?php if (!empty($userData['imagen'])) : ?>
                                    <img src="<?php echo htmlspecialchars($userData['imagen'], ENT_QUOTES, 'UTF-8'); ?>" class="img-fluid rounded" alt="Imagen de perfil">
                                <?php endif; ?>
                            </div>
                            <div class="col-md-8">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <strong>Nombre:</strong> <?php echo htmlspecialchars($userData['Nombre'], ENT_QUOTES, 'UTF-8'); ?>
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Apellido:</strong> <?php echo htmlspecialchars($userData['Apellido'], ENT_QUOTES, 'UTF-8'); ?>
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Email:</strong> <?php echo htmlspecialchars($userData['Email'], ENT_QUOTES, 'UTF-8'); ?>
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Nacimiento:</strong> <?php echo htmlspecialchars($userData['Nacimiento'], ENT_QUOTES, 'UTF-8'); ?>
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Descripción:</strong> <?php echo htmlspecialchars($userData['Descripcion'], ENT_QUOTES, 'UTF-8'); ?>
                                    </li>
                                    <!-- Agrega más campos según sea necesario -->
                                </ul><br>
                                <button type="button" class="btn btn-primary editPerfilBtn" data-bs-toggle="modal" data-bs-target="#editPerfil" data-user-id="<?php echo $userData['UserID']; ?>">Editar perfil</button>
                            </div>
                            <?php
                        } else {
                            // Manejo si no se pueden obtener los datos del usuario
                            echo '<div class="alert alert-danger" role="alert">Error al obtener datos del usuario.</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="editPerfil" tabindex="-1" role="dialog" aria-labelledby="editPerfilModal" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form id="perfilForm" enctype="multipart/form-data" style="margin: 10px;">
                            <div class="mb-3">
                                <label for="imagen" class="form-label">Imagen de Perfil:</label>
                                <input type="file" class="form-control" id="imagen" name="imagen">
                            </div>
                            <div class="mb-2">
                                <label for="imagenPreview" class="form-label">Vista previa tu imágen actual:</label>
                                <div id="imagenPreview" class="mb-3"></div>
                            </div>
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
                                <input type="text" class="form-control" id="numeroCuenta" placeholder="Introduce un número de cuenta válido" name="numeroCuenta">
                            </div>
                            <div class="mb-3">
                                <label for="direccion" class="form-label">Dirección:</label>
                                <input type="text" class="form-control" id="direccion" placeholder="Introduce nueva dirección" name="direccion">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña:</label>
                                <input type="password" class="form-control" id="password" placeholder="Introduce nueva contraseña" name="password">
                            </div>
                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripcion:</label>
                                <textarea id="descripcion" class="form-control" name="descripcion"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-primary" onclick="actualizarPerfil(<?php echo $_SESSION['user_id']?>)">Actualizar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div id ="notificaciones" class="tabContent" style="display: none; height: 100%;">
                <h2 class="mb-4">Tus notificaciones</h2>
                <div class="container mt-5">
                    <div id="notificacionesAccordion" class="accordion" data-user-id="<?php echo $_SESSION['user_id']?>">
                        <!-- Aquí se mostrarán las notificaciones -->
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
                    <div class="container-fluid" style="overflow-y: auto; max-height: 120vh;">
                        <div class="d-flex flex-column align-items-stretch"> <!-- Asegurarse de estirar los elementos de la columna -->

                            <?php
                            $reservas = getReservas($_SESSION['user_id']); // Obtiene las reservas del usuario
                            foreach ($reservas as $reserva) {
                                ?>
                                <div class="card border shadow-none mb-4 reservas" data-fecha-inicio="<?php echo $reserva['FechaInicio']; ?>" data-fecha-fin="<?php echo $reserva['FechaFin']; ?>" data-reserva-id="<?php echo $reserva['ReservationID']; ?>">
                                    <div class="card-body">
                                        <div class="d-flex align-items-start border-bottom pb-3 flex-md-row flex-column">
                                            <div class="me-4">
                                                <?php
                                                $imagenes = $reserva['Imagenes'];
                                                if (!empty($imagenes)) {
                                                    ?>
                                                    <div id="carousel-<?php echo $reserva['ReservationID']; ?>" class="carousel slide avatar-lg rounded" data-ride="carousel">
                                                        <div class="carousel-inner">
                                                            <?php
                                                            foreach ($imagenes as $index => $imagen) {
                                                                $activeClass = ($index == 0) ? 'active' : '';
                                                                ?>
                                                                <div class="carousel-item <?php echo $activeClass; ?>" data-bs-interval="2000">
                                                                    <img src="<?php echo $imagen; ?>" class="d-block w-100 img-fluid" alt="Imagen <?php echo $index; ?>">
                                                                </div>
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <?php
                                                } else {
                                                    // Mostrar una imagen predeterminada si no hay imágenes disponibles
                                                    ?>
                                                    <img src="https://www.bootdey.com/image/380x380/FF00FF/000000" alt="" class="avatar-lg rounded img-fluid">
                                                    <?php
                                                }
                                                ?>
                                            </div>

                                            <div class="flex-grow-1 align-self-center overflow-hidden">
                                                <div class="order-md-2">
                                                    <h5 class="text-truncate font-size-18"><a class="text-dark"><?php echo $reserva['Marca'] . " " . $reserva['Modelo']; ?></a></h5>
                                                    <div class="row row-cols-md-2">
                                                        <div class="col-md-6"><strong>Año: </strong><?php echo $reserva['Ano']; ?></div>
                                                        <div class="col-md-6"><strong>Potencia: </strong><?php echo $reserva['Potencia']; ?></div>
                                                        <div class="col-md-6"><strong>Autonomia: </strong><?php echo $reserva['Autonomia']; ?></div>
                                                        <div class="col-md-6"><strong>Motorizacion: </strong><?php echo $reserva['Motorizacion']; ?></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="flex-shrink-0 ms-2">
                                                <ul class="list-inline mb-0 font-size-16">
                                                    <li class="list-inline-item">
                                                        <a href="#" class="text-muted px-1 eliminarReserva" onclick="eliminarReserva(<?php echo $reserva['ReservationID']; ?>, <?php echo $reserva['UserID']; ?>)">
                                                            <i class="mdi mdi-trash-can-outline"></i> Eliminar
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col">
                                                <div class="mt-3">
                                                    <p class="text-muted mb-2">Fecha de Inicio</p>
                                                    <h5 class="mb-0 mt-2"><?php echo $reserva['FechaInicio']; ?></h5>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="mt-3">
                                                    <p class="text-muted mb-2">Fecha de Fin</p>
                                                    <h5 class="mb-0 mt-2"><?php echo $reserva['FechaFin']; ?></h5>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="mt-3">
                                                    <p class="text-muted mb-2">Precio</p>
                                                    <h5 class="mb-0 mt-2"><?php echo $reserva['Coste']; ?>€</h5>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="mt-3">
                                                    <p class="text-muted mb-2">Observaciones</p>
                                                    <h5 class="mb-0 mt-2"><?php echo $reserva['Observaciones']; ?></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

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
                        <form id="editCarForm" enctype="multipart/form-data">
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
                        <form action="backend.php" enctype="multipart/form-data">
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
                                                <select class="form-select" id="motorizacion" name="Motorizacion" required>
                                                    <option value="Hibrido">Híbrido</option>
                                                    <option value="Electrico">Eléctrico</option>
                                                </select>
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
        </div>
    </div>
</div>

<div class="toast-container position-fixed bottom-0 end-0 p-3" data-user-id="<?php echo $_SESSION['user_id']?>">
</div>

<?php
include ("footer.php");
?>

<script src="control_panel.js"></script>
<script src="notification.js" type="module"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
