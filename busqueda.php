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
    <link rel="stylesheet" href="style.css">
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

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar para filtros -->
        <div class="col-lg-2 bg-body-tertiary">
            <div class="accordion" id="accordionFilters">
                <!-- Filtro Marca -->
                <div class="accordion-item filtro" data-filtro="marca">
                    <h2 class="accordion-header" id="headingMarca">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMarca" aria-expanded="true" aria-controls="collapseMarca">
                            Marca
                        </button>
                    </h2>
                    <div id="collapseMarca" class="accordion-collapse collapse show" aria-labelledby="headingMarca" data-bs-parent="#accordionFilters">
                        <div class="accordion-body">
                            <?php
                            // Supuestamente estas variables contienen arrays de valores únicos obtenidos de la base de datos
                            $marcas = get_unique_values('Marca', 'coches');
                            foreach($marcas as $marca):
                                ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="<?php echo $marca; ?>" id="marca<?php echo $marca; ?>">
                                    <label class="form-check-label" for="marca<?php echo $marca; ?>">
                                        <?php echo $marca; ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Filtro Modelo -->
                <div class="accordion-item filtro" data-filtro="modelo">
                    <h2 class="accordion-header" id="headingModelo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseModelo" aria-expanded="false" aria-controls="collapseModelo">
                            Modelo
                        </button>
                    </h2>
                    <div id="collapseModelo" class="accordion-collapse collapse" aria-labelledby="headingModelo" data-bs-parent="#accordionFilters">
                        <div class="accordion-body">
                            <?php
                            $modelos = get_unique_values('Modelo', 'coches');
                            foreach($modelos as $modelo):
                                ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="<?php echo $modelo; ?>" id="modelo<?php echo $modelo; ?>">
                                    <label class="form-check-label" for="modelo<?php echo $modelo; ?>">
                                        <?php echo $modelo; ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Filtro Año -->
                <div class="accordion-item filtro" data-filtro="ano">
                    <h2 class="accordion-header" id="headingAno">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAno" aria-expanded="false" aria-controls="collapseAno">
                            Año
                        </button>
                    </h2>
                    <div id="collapseAno" class="accordion-collapse collapse" aria-labelledby="headingAno" data-bs-parent="#accordionFilters">
                        <div class="accordion-body">
                            <?php
                            $anos = get_unique_values('Ano', 'coches');
                            foreach($anos as $ano):
                                ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="<?php echo $ano; ?>" id="ano<?php echo $ano; ?>">
                                    <label class="form-check-label" for="ano<?php echo $ano; ?>">
                                        <?php echo $ano; ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Filtro Kilometraje -->
                <div class="accordion-item filtro" data-filtro="kilometraje">
                    <h2 class="accordion-header" id="headingKilometraje">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseKilometraje" aria-expanded="false" aria-controls="collapseKilometraje">
                            Kilometraje
                        </button>
                    </h2>
                    <div id="collapseKilometraje" class="accordion-collapse collapse" aria-labelledby="headingKilometraje" data-bs-parent="#accordionFilters">
                        <div class="accordion-body">
                            <?php
                            $kilometrajes = get_unique_values('Kilometraje', 'coches');
                            foreach($kilometrajes as $kilometraje):
                                ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="<?php echo $kilometraje; ?>" id="kilometraje<?php echo $kilometraje; ?>">
                                    <label class="form-check-label" for="kilometraje<?php echo $kilometraje; ?>">
                                        <?php echo $kilometraje; ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Filtro Precio -->
                <div class="accordion-item filtro" data-filtro="precio">
                    <h2 class="accordion-header" id="headingPrecio">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePrecio" aria-expanded="false" aria-controls="collapsePrecio">
                            Precio
                        </button>
                    </h2>
                    <div id="collapsePrecio" class="accordion-collapse collapse" aria-labelledby="headingPrecio" data-bs-parent="#accordionFilters">
                        <div class="accordion-body">
                            <?php
                            $precios = get_unique_values('Precio', 'coches');
                            foreach($precios as $precio):
                                ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="<?php echo $precio; ?>" id="precio<?php echo $precio; ?>">
                                    <label class="form-check-label" for="precio<?php echo $precio; ?>">
                                        <?php echo $precio; ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contenido principal de coches y paginación -->
        <div class="col-lg-10">
            <div id="cars-container" class="row" style="margin-top: 1%">
                <!-- Los coches se cargarán aquí mediante JavaScript -->
            </div>

            <!-- Paginación -->
            <nav aria-label="Page navigation" style="margin-top: 1%">
                <ul id="pagination" class="pagination justify-content-center">
                    <!-- Los enlaces de paginación se generarán aquí mediante JavaScript -->
                </ul>
            </nav>
        </div>
    </div>
</div>


<!-- Modal Detalles Coche -->
<div class="modal fade" id="detalles-coche" tabindex="-1" aria-labelledby="detalles-cocheLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #2575fc;">
                <h5 class="modal-title" id="carTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img alt="Imagen del Coche" id="carImage" class="img-fluid">
                <!-- Aquí va el acordeón -->
                <div class="accordion" id="accordionCarDetails">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                Datos del coche
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionCarDetails">
                            <div class="accordion-body">
                                <h3 id="carTitle"></h3>
                                <p id="carYear"></p>
                                <p id="carMileage"></p>
                                <p id="carDescription"></p>
                                <p id="carPrice"></p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseCarTwo">
                                Ubicación del vehículo
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo">
                            <div class="accordion-body">

                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Fechas
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree">
                            <div class="accordion-body">
                                <!-- Campo para la selección del rango de fechas -->
                                <label for="dateRangePicker"></label><input type="text" id="dateRangePicker" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                Condiciones del servicio
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour">
                            <div class="accordion-body">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btnSiguiente">Siguiente</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include ("footer.php");
?>

<script src="busqueda.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
