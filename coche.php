<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("funciones_BD.php");
$carID = $_GET['CarID'];
$car = getCar($carID);
print_r($car);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title> Proyecto EV - <?php echo $car[0]['Marca'] . ' ' . $car[0]['Modelo']; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/litepicker.js"></script>
    <script src="https://kit.fontawesome.com/305aef3688.js" crossorigin="anonymous"></script>

    <!-- Estilos adicionales -->
    <style>
        .car-details {
            margin-top: 2rem;
        }
        .car-image {
            width: 100%;
            height: auto;
        }
        .car-description {
            margin-top: 1rem;
        }
        .car-image {
            display: block;
            width: auto;
            height: 30vh;
            object-fit: cover;
        }
        .rounded-carousel {
            border-radius: 15px; /* Puedes ajustar este valor a tu gusto */
            overflow: hidden; /* Esto asegura que las imágenes también se recorten al radio de borde */
        }

        .col-md-7 {
            border-radius: 15px;
            background: #F8F9FA;
            border: 2px solid #0dcaf0; /* Establece el color del borde */
        }

        .profile {
            border-radius: 15px;
            background: #F8F9FA;
            border: 2px solid #0dcaf0; /* Establece el color del borde */
            position: sticky;
            top: 0;
        }

        .especificaciones {
            border-radius: 15px;
            border: 2px solid #0dcaf0; /* Establece el color del borde */
        }

        .specs-data {
            padding: 10px;
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

         :root {
             --litepicker-is-locked-color: red; !important;
         }

    </style>
</head>
<body>

<header>
    <?php require("header.php"); ?>
</header>

<!-- Formularios -->
<?php include("login.php"); ?>
<?php include("register.php"); ?>

<!-- Resto del body aquí -->

<div class="container car-details">
    <div class="row">
        <div class="col-md-7">
            <h2><?php echo $car[0]['Marca'] . ' ' . $car[0]['Modelo']; ?></h2>

            <!-- Carrusel completo incluyendo indicadores y controles -->
            <div id="carCarousel" class="carousel slide rounded-carousel" data-bs-ride="carousel">
                <!-- Indicadores del carrusel -->
                <div class="carousel-indicators">
                    <?php foreach ($car[0]['Imagenes'] as $index => $imagen): ?>
                        <button type="button" data-bs-target="#carCarousel" data-bs-slide-to="<?php echo $index; ?>" <?php echo $index == 0 ? 'class="active" aria-current="true"' : ''; ?> aria-label="Slide <?php echo $index + 1; ?>"></button>
                    <?php endforeach; ?>
                </div>

                <!-- Imágenes del carrusel -->
                <div class="carousel-inner">
                    <?php foreach ($car[0]['Imagenes'] as $index => $imagen): ?>
                        <div class="carousel-item <?php echo $index == 0 ? 'active' : ''; ?>">
                            <img src="<?php echo $imagen; ?>" class="car-image d-block w-100" alt="<?php echo $car[0]['Marca'] . ' ' . $car[0]['Modelo']; ?>">
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Controles del carrusel -->
                <button class="carousel-control-prev" type="button" data-bs-target="#carCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>

            <div class="car-description">
                <div class="py-3 mb-3">
                    <div class="especificaciones">
                        <h2 class="h4 mb-4 specs-data">Especificaciones</h2>
                        <div class="row specs-data">
                            <div class="col-sm-6 col-md-12 col-lg-6">
                                <ul class="list-unstyled">
                                    <li class="mb-2"><i class="fa-solid fa-calendar-days"></i> <strong>Año:</strong><span class="opacity-70 ms-1"><?php echo $car[0]['Ano']; ?></span></li>
                                    <li class="mb-2"><i class="fa-solid fa-address-card"></i> <strong>Matricula:</strong><span class="opacity-70 ms-1"><?php echo $car[0]['Matricula']; ?></span></li>
                                    <li class="mb-2"><i class="fa-solid fa-gauge-high"></i> <strong>Potencia:</strong><span class="opacity-70 ms-1"><?php echo $car[0]['Potencia']; ?></span></li>
                                    <li class="mb-2"><i class="fa-solid fa-charging-station"></i> <strong>Autonomia:</strong><span class="opacity-70 ms-1"><?php echo $car[0]['Autonomia']; ?></span></li>
                                    <li class="mb-2"><i class="fa-solid fa-road"></i> <strong>Kilometraje:</strong><span class="opacity-70 ms-1"><?php echo $car[0]['Kilometraje']; ?></span></li>
                                </ul>
                            </div>
                            <div class="col-sm-6 col-md-12 col-lg-6">
                                <ul class="list-unstyled">
                                    <li class="mb-2"><i class="fa-solid fa-oil-can"></i> <strong>Motorizacion:</strong><span class="opacity-70 ms-1"><?php echo $car[0]['Motorizacion']; ?></span></li>
                                    <li class="mb-2"><i class="fa-solid fa-biohazard"></i> <strong>Contaminación:</strong><span class="opacity-70 ms-1"><?php echo $car[0]['Contaminacion']; ?> G/Km</span></li>
                                    <li class="mb-2"><i class="fa-solid fa-landmark"></i> <strong>Precio:</strong><span class="opacity-70 ms-1"><?php echo number_format($car[0]['Precio'], 2); ?>€/día</span></li>
                                    <li class="mb-2"><i class="fa-solid fa-car"></i> <strong>Tipo:</strong><span class="opacity-70 ms-1"><?php echo $car[0]['Tipo']; ?></span></li>
                                    <li class="mb-2"><i class="fa-solid fa-map"></i> <strong>Ubicacion:</strong><span class="opacity-70 ms-1"><?php echo $car[0]['ubicacion']; ?></span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="row col-sm-6 col-md-12 col-lg-6 specs-data">
                            <ul class="list-unstyled">
                                <p><i class="fa-solid fa-list-check"></i> <strong>Descripción:</strong></p>
                                <?php echo $car[0]['Descripcion']; ?>
                            </ul>
                        </div><br>
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
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <?php echo $car[0]['Exterior']; ?>
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
                                        <?php echo $car[0]['Interior']; ?>
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
                                        <?php echo $car[0]['Seguridad']; ?>
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
                                        <?php echo $car[0]['Tecnologia']; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5 col-sticky">
            <div class="card mb-3 profile" style="max-width: 540px;">
                <?php $ownerData = getUserData($car[0]['UserID']);?>
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="<?php echo $ownerData['imagen'];?>" class="rounded img-fluid" alt="Imágen de perfil" style="margin: 5%;">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">Información del Anunciante</h5>
                            <h6 class="card-title"><?php echo $ownerData['Nombre'] . " " . $ownerData['Apellido']; ?></h6>
                            <h6 class="card-title"><?php echo $ownerData['Email'];?></h6>
                            <p class="card-text"><?php echo $ownerData['Descripcion'];?></p>
                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                        </div>
                        <div class="card-body">
                            <?php if(isset($_SESSION['user_id'])): ?>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#comprarModal" onclick="loadCarDetails(<?php echo htmlspecialchars(json_encode($car[0]['CarID']), ENT_QUOTES, 'UTF-8'); ?>)">
                                Alquilar
                            </button>
                            <button type="button" class="btn btn-toggle-favorito" onclick="toggleFavorito(this)" data-car-id="<?php echo $car[0]['CarID']?>" data-favorited="false">
                                <i class="fa fa-star-o"></i> Añadir a Favoritos
                            </button>
                            <?php else: ?>
                            <button type="button" class="btn btn-primary"><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Login para ver mas opciones</a></button>
                            <?php endif?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Comprar -->
<div class="modal fade" id="comprarModal" tabindex="-1" aria-labelledby="detalles-cocheLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="modal-body">
                            <div class="car-details">
                                <div class="accordion" id="accordionCarDetails">
                                    <h3 id="carTitle"></h3>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingTwo">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseCarTwo">
                                                Ubicación del vehículo
                                            </button>
                                        </h2>
                                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#comprarModal">
                                            <div class="accordion-body">
                                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d397142.1769148011!2d-6.39879255!3d38.9542923!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd1426b8c9359ae9%3A0xbe6ed2ee13cfca3f!2sM%C3%A9rida%2C%2006800%2C%20Badajoz!5e0!3m2!1ses!2ses!4v1700044104021!5m2!1ses!2ses"
                                                        width="690"
                                                        height="500"
                                                        style="border:0;"
                                                        allowfullscreen=""
                                                        loading="lazy"
                                                        referrerpolicy="no-referrer-when-downgrade">
                                                </iframe>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingThree">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                Fechas
                                            </button>
                                        </h2>
                                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#comprarModal">
                                            <div class="accordion-body">
                                                <!-- Campo para la selección del rango de fechas -->
                                                <label for="dateRangePicker"></label>
                                                <input type="text" id="dateRangePicker" class="form-control" data-car-id="<?php echo $car[0]['CarID']?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingFour">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                                Condiciones del servicio
                                            </button>
                                        </h2>
                                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#comprarModal">
                                            <div class="accordion-body">
                                                <h5>1. Alquiler de Coches</h5>
                                                <p>
                                                    Al alquilar un coche híbrido o eléctrico con nosotros, aceptas cumplir con los términos y condiciones establecidos en este acuerdo. El alquiler está sujeto a la disponibilidad de los vehículos.
                                                </p>

                                                <h5>2. Requisitos del Conductor</h5>
                                                <p>
                                                    Para alquilar un coche, debes tener al menos 18 años y poseer una licencia de conducir válida. Algunos vehículos pueden tener requisitos adicionales de edad y licencia.
                                                </p>

                                                <h5>3. Reservas</h5>
                                                <p>
                                                    Las reservas están sujetas a disponibilidad. Te recomendamos realizar tu reserva con anticipación para garantizar la disponibilidad de un coche híbrido o eléctrico.
                                                </p>

                                                <h5>4. Tarifas y Pagos</h5>
                                                <p>
                                                    Las tarifas de alquiler se basan en la duración del alquiler y el tipo de vehículo seleccionado. Los pagos se realizarán según el método especificado al realizar la reserva.
                                                </p>

                                                <h5>5. Política de Cancelación</h5>
                                                <p>
                                                    Para cancelar una reserva, debes notificarlo con al menos 48 horas de antelación. Las cancelaciones dentro de las 48 horas pueden estar sujetas a tarifas adicionales.
                                                </p>

                                                <h5>6. Mantenimiento del Vehículo</h5>
                                                <p>
                                                    Los coches se proporcionan en condiciones de funcionamiento óptimas. Es responsabilidad del conductor informar cualquier problema o necesidad de mantenimiento durante el período de alquiler.
                                                </p>

                                                <h5>7. Combustible y Carga</h5>
                                                <p>
                                                    Los coches se entregarán con un nivel de combustible o carga especificado. Es responsabilidad del conductor devolver el vehículo con el mismo nivel de combustible o carga. Se pueden aplicar tarifas por niveles bajos al regreso.
                                                </p>

                                                <h5>8. Uso del Vehículo</h5>
                                                <p>
                                                    Los vehículos deben usarse de acuerdo con las leyes de tráfico y no deben utilizarse para fines ilegales o no permitidos. El incumplimiento de estas condiciones puede resultar en cargos adicionales.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <ul class="list-group" id="precioTotal" data-precio-base="<?php echo $car[0]['Precio']; ?>">
                                            <li class="list-group-item active">Coste total: <span id="precioValor"><?php echo number_format($car[0]['Precio'], 2); ?></span></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary btn-cancelar" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="button" class="btn btn-primary btn-siguiente">Siguiente</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="toast-container position-fixed bottom-0 end-0 p-3" data-user-id="<?php echo $_SESSION['user_id']?>">
</div>

<footer class="container-fluid text-center">
    <?php include("footer.php"); ?>
</footer>

<script src="coche.js"></script>
<script src="notification.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>