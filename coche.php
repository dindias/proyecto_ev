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
                            <img src="../<?php echo $imagen; ?>" class="car-image d-block w-100" alt="<?php echo $car[0]['Marca'] . ' ' . $car[0]['Modelo']; ?>">
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
                    <h2 class="h4 mb-4">Especificaciones</h2>
                    <div class="row">
                        <div class="col-sm-6 col-md-12 col-lg-6">
                            <ul class="list-unstyled">
                                <li class="mb-2"><strong>Año:</strong><span class="opacity-70 ms-1"><?php echo $car[0]['Ano']; ?></span></li>
                                <li class="mb-2"><strong>Matricula:</strong><span class="opacity-70 ms-1"><?php echo $car[0]['Matricula']; ?></span></li>
                                <li class="mb-2"><strong>Potencia:</strong><span class="opacity-70 ms-1"><?php echo $car[0]['Potencia']; ?></span></li>
                                <li class="mb-2"><strong>Autonomia:</strong><span class="opacity-70 ms-1"><?php echo $car[0]['Autonomia']; ?></span></li>
                                <li class="mb-2"><strong>Kilometraje:</strong><span class="opacity-70 ms-1"><?php echo $car[0]['Kilometraje']; ?></span></li>
                            </ul>
                        </div>
                        <div class="col-sm-6 col-md-12 col-lg-6">
                            <ul class="list-unstyled">
                                <li class="mb-2"><strong>Motorizacion:</strong><span class="opacity-70 ms-1"><?php echo $car[0]['Motorizacion']; ?></span></li>
                                <li class="mb-2"><strong>Contaminación:</strong><span class="opacity-70 ms-1"><?php echo $car[0]['Contaminacion']; ?></span></li>
                                <li class="mb-2"><strong>Precio:</strong><span class="opacity-70 ms-1"><?php echo number_format($car[0]['Precio'], 2); ?></span></li>
                                <li class="mb-2"><strong>Tipo:</strong><span class="opacity-70 ms-1"><?php echo $car[0]['Tipo']; ?></span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <p><strong>Descripción:</strong></p>
                        <?php echo $car[0]['Descripcion']; ?>
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
                                        <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
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
                                        <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
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
                                        <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
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
                                        <strong>This is the fourth item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">

        </div>
    </div>
</div>

<footer class="container-fluid text-center">
    <?php include("footer.php"); ?>
</footer>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>