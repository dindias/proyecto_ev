<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include("funciones_BD.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Hispania EV</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/litepicker.js"></script>
    <script src="https://kit.fontawesome.com/305aef3688.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header class="sticky-top">
    <?php
    require("header.php");
    ?>
</header>

<!-- Formulario login -->
<?php
include("login.php");
?>

<!-- Formulario login -->
<?php
include("register.php");
?>

<div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner" style="max-height: 90vh">
        <div class="carousel-item active" data-bs-interval="10000">
            <img src="img/turismo_ID.png" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item" data-bs-interval="10000">
            <img src="img/ford-electric.jpg" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item" data-bs-interval="10000">
            <img src="img/toyota-electric.jpg" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-caption d-none d-md-block" style="position: absolute; width: 50%; margin: auto auto 10%;background-color: rgba(89, 108, 114, 0.8); border: 2px solid #ADD8E6; border-radius: 10px; padding: 10px;">
            <h2>Bienvenido a nuestro servicio de alquiler de coches eléctricos</h2>
            <p>Descubre una nueva forma de movilidad sostenible. Explora nuestra flota de coches eléctricos y encuentra el vehículo perfecto para ti.</p>
            <a href="busqueda.php" class="btn btn-primary">Buscar tu coche</a>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<div class="container mt-4">
    <h3>Y tú, ¿Condúces?</h3>

    <div class="row mt-4">
        <!-- Tipo de coche: Compacto -->
        <div class="col-md-3 mb-4">
            <div class="card filtro-tipo" data-tipo="Compacto">
                <img src="img/tipos_coche/compacto.jpg" class="card-img-top" alt="Imagen del coche">
                <div class="card-body text-wrap">
                    <h5 class="card-title">Compacto</h5>
                    <p class="card-text">Ideal para la ciudad, pequeño pero lleno de estilo.</p>
                </div>
            </div>
        </div>

        <!-- Tipo de coche: Berlina -->
        <div class="col-md-3 mb-4">
            <div class="card filtro-tipo" data-tipo="Berlina">
                <img src="img/tipos_coche/berlina.jpg" class="card-img-top" alt="Imagen del coche">
                <div class="card-body text-wrap">
                    <h5 class="card-title">Berlina</h5>
                    <p class="card-text">Elegancia y comodidad en cada viaje, perfecto para largos trayectos.</p>
                </div>
            </div>
        </div>

        <!-- Tipo de coche: Suv -->
        <div class="col-md-3 mb-4">
            <div class="card filtro-tipo" data-tipo="Suv">
                <img src="img/tipos_coche/suv.jpg" class="card-img-top" alt="Imagen del coche">
                <div class="card-body text-wrap">
                    <h5 class="card-title">Suv</h5>
                    <p class="card-text">Potencia y versatilidad, listo para cualquier aventura fuera de la carretera.</p>
                </div>
            </div>
        </div>

        <!-- Tipo de coche: Coupé -->
        <div class="col-md-3 mb-4">
            <div class="card filtro-tipo" data-tipo="Coupe">
                <img src="img/tipos_coche/coupe.jpg" class="card-img-top" alt="Imagen del coche">
                <div class="card-body text-wrap">
                    <h5 class="card-title">Coupé</h5>
                    <p class="card-text">Estilo deportivo y elegante, diseñado para quienes aman la velocidad.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Tipo de coche: Familiar -->
        <div class="col-md-3 mb-4">
            <div class="card filtro-tipo" data-tipo="Familiar">
                <img src="img/tipos_coche/familiar.jpg" class="card-img-top" alt="Imagen del coche">
                <div class="card-body text-wrap">
                    <h5 class="card-title">Familiar</h5>
                    <p class="card-text">Espacioso y cómodo, perfecto para toda la familia en cada viaje.</p>
                </div>
            </div>
        </div>

        <!-- Tipo de coche: Cabrio -->
        <div class="col-md-3 mb-4">
            <div class="card filtro-tipo" data-tipo="Cabrio">
                <img src="img/tipos_coche/cabrio.jpg" class="card-img-top" alt="Imagen del coche">
                <div class="card-body text-wrap">
                    <h5 class="card-title">Cabrio</h5>
                    <p class="card-text">Siente la brisa y disfruta del sol con este coche descapotable.</p>
                </div>
            </div>
        </div>

        <!-- Tipo de coche: Industrial -->
        <div class="col-md-3 mb-4">
            <div class="card filtro-tipo" data-tipo="Industrial">
                <img src="img/tipos_coche/industrial.jpg" class="card-img-top" alt="Imagen del coche">
                <div class="card-body text-wrap">
                    <h5 class="card-title">Industrial</h5>
                    <p class="card-text">Potencia y resistencia para trabajos duros, ¡listo para la acción!</p>
                </div>
            </div>
        </div>

        <!-- Otro tipo de coche -->
        <div class="col-md-3 mb-4">
            <div class="card filtro-tipo">
                <img src="img/tipos_coche/hibrido.jpg" class="card-img-top" alt="Imagen del coche">
                <div class="card-body text-wrap">
                    <h5 class="card-title">Otro</h5>
                    <p class="card-text">Encuentra aquí coches únicos y diferentes, ¡explora nuevas opciones!</p>
                    <p><span class="arrow" onclick="autoToggle()">Ver más</span></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Ultimas adiciones de coches aqui -->
<div class="container mt-5">
    <h2 class="mb-4">Últimas Adiciones</h2>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
        <?php
        $ultimasAdiciones = getUltimasAdiciones();

        foreach ($ultimasAdiciones as $coche) {
            $imagenes = explode(",", $coche['Imagenes']);
            ?>
            <div class="col">
                <div class="card h-100">
                    <div id="carousel-<?php echo $coche['CarID']; ?>" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php
                            foreach ($imagenes as $index => $imagen) {
                                ?>
                                <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                    <img src="<?php echo $imagen; ?>" class="d-block card-img-top w-100" alt="Imagen del coche">
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carousel-<?php echo $coche['CarID']; ?>" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Anterior</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carousel-<?php echo $coche['CarID']; ?>" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Siguiente</span>
                        </button>
                    </div>
                    <?php $encodedParams = json_encode(["CarID" => $coche['CarID'], "Marca" => $coche['Marca'], "Modelo" => $coche['Modelo']]); ?>
                    <div class="card-body" onclick="redirectToCarDetails('<?php echo urlencode($encodedParams); ?>')" style="cursor: pointer;">
                        <h5 class="card-title"><?php echo $coche['Marca'] . ' ' . $coche['Modelo']; ?></h5>
                        <p class="card-text">Motorización: <?php echo $coche['Motorizacion']; ?></p>
                        <p class="card-text">Año: <?php echo $coche['Ano']; ?></p>
                        <p class="card-text">Precio: <?php echo $coche['Precio']; ?>€/día</p>
                        <p class="card-text">Ubicacion: <?php echo $coche['ubicacion']; ?></p>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div><br>
</div>

<div class="toast-container position-fixed bottom-0 end-0 p-3" data-user-id="<?php echo $_SESSION['user_id']?>">
</div>


<?php
include("footer.php");
?>

<script src="js"></script>
<script src="js/notification.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
