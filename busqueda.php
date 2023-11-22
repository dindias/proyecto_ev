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
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['tipo'])) {
        $tipo = $_POST['tipo'];
        // Aquí agregarías la lógica para filtrar los coches por el tipo que recibiste y mostrarlos.
        // Esta función supuestamente recargaría los coches con el filtro aplicado.
        loadCarsWithFilter($tipo);
    }
    // Aquí iría el resto del código que genera la página 'busqueda.php'.
}

?>
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

                <!-- Filtro Potencia -->
                <div class="accordion-item filtro" data-filtro="potencia">
                    <h2 class="accordion-header" id="headingPotencia">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePotencia" aria-expanded="false" aria-controls="collapsePotencia">
                            Potencia
                        </button>
                    </h2>
                    <div id="collapsePotencia" class="accordion-collapse collapse" aria-labelledby="headingPotencia" data-bs-parent="#accordionFilters">
                        <div class="accordion-body">
                            <?php
                            $potencia = get_unique_values('Potencia', 'coches');
                            foreach($potencia as $hp):
                                ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="<?php echo $hp; ?>" id="Potencia<?php echo $hp; ?>">
                                    <label class="form-check-label" for="Potencia<?php echo $hp; ?>">
                                        <?php echo $hp; ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <!-- Filtro Autonomia -->
                <div class="accordion-item filtro" data-filtro="autonomia">
                    <h2 class="accordion-header" id="headingAutonomia">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAutonomia" aria-expanded="false" aria-controls="collapseAutonomia">
                            Autonomia
                        </button>
                    </h2>
                    <div id="collapseAutonomia" class="accordion-collapse collapse" aria-labelledby="headingAutonomia" data-bs-parent="#accordionFilters">
                        <div class="accordion-body">
                            <?php
                            $autonomia = get_unique_values('Autonomia', 'coches');
                            foreach($autonomia as $distancia):
                                ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="<?php echo $distancia; ?>" id="distancia<?php echo $distancia; ?>">
                                    <label class="form-check-label" for="distancia<?php echo $distancia; ?>">
                                        <?php echo $distancia; ?>
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

                <div class="accordion-item filtro" data-filtro="tipo">
                    <h2 class="accordion-header" id="headingTipo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTipo" aria-expanded="false" aria-controls="collapseTipo">
                            Tipo
                        </button>
                    </h2>
                    <div id="collapseTipo" class="accordion-collapse collapse" aria-labelledby="headingTipo" data-bs-parent="#accordionFilters">
                        <div class="accordion-body">
                            <?php
                            // Definimos la lista de tipos de coche directamente
                            $tipos = array('Berlina', 'Cabrio', 'Compacto', 'Coupe', 'Familiar', 'Híbrido', 'Industrial', 'Suv');

                            foreach($tipos as $tipo):
                                ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="<?php echo $tipo; ?>" id="tipo<?php echo $tipo; ?>">
                                    <label class="form-check-label" for="tipo<?php echo $tipo; ?>">
                                        <?php echo $tipo; ?>
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

<div class="toast-container position-fixed bottom-0 end-0 p-3" data-user-id="<?php echo $_SESSION['user_id']?>">
</div>

<?php
include ("footer.php");
?>

<script src="busqueda.js"></script>
<script src="notification.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
