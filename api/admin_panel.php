<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include("funciones_BD.php");
if (!isset($_SESSION['user_id']) || !isAdmin($_SESSION['user_id'])) {
    // Redirigir a la página de inicio de sesión o cualquier otra página
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <title>Panel de administrador</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/305aef3688.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns@3"></script>
    <link rel="stylesheet" href="css/control_panel.css">
</head>
<body>

<header>
    <?php
    require("header.php");
    ?>
</header>

<!-- Formulario login -->
<?php
include("login.php");
?>

<!-- Formulario registro -->
<?php
include("register.php");
?>
<!-- Resto del body aquí -->

<div class="container-flex" style="margin: 15px;">
    <div class="row">
        <div class="container mt-5">
            <h2 class="mb-4">Datos de relevancia</h2>
            <div class="row">
                <!-- Columna 1 -->
                <div class="col-sm-6 col-md-3 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Usuarios registrados</h5>
                            <canvas id="registrationChart" width="200" height="200"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Columna 2 -->
                <div class="col-sm-6 col-md-3 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Contaminación por marca</h5>
                            <canvas id="contaminationChart" width="800" height="400"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Columna 3 -->
                <div class="col-sm-6 col-md-3 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Cantidad de coches por tipo</h5>
                            <canvas id="tiposCocheChart" width="800" height="400"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Columna 4 -->
                <div class="col-sm-6 col-md-3 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Evolucion de registros</h5>
                            <canvas id="reservasChart" width="800" height="400"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" id="cochesTab" href="#coches" onclick="showTab('coches'); return false;">Coches</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="favoritosTab" href="#favoritos" onclick="showTab('favoritos'); return false;">Favoritos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="reservasTab" href="#reservas" onclick="showTab('reservas'); return false;">Reservas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="usuariosTab" href="#usuarios" onclick="showTab('usuarios'); return false;">Usuarios</a>
            </li>
        </ul>

        <div id="coches" class="tabContent" style="display: none; height: 100%;">
            <h2 class="mb-4">Datos de coches</h2>
            <div class="d-flex justify-content-center">
                <div class="input-group mb-3" style="max-width: 500px;">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="columnButtonCoches">Columna</button>
                    <ul class="dropdown-menu" id="columnDropdownCoches">
                        <!-- Los nombres de las columnas se agregarán aquí dinámicamente -->
                    </ul>
                    <input type="text" class="form-control" id="searchInputCoches" aria-label="Text input with dropdown button" placeholder="Buscar...">
                </div>
            </div>
            <div class="container-fluid" id="cochesTablaContainer"></div>
            <div id="paginacionCoches" class="mt-3">
                <!-- Aquí se generarán los botones de paginación -->
            </div>
        </div>

        <div id="favoritos" class="tabContent" style="display: none; height: 100%;">
            <h2 class="mb-4">Datos de favoritos</h2>
            <div class="d-flex justify-content-center">
                <div class="input-group mb-3" style="max-width: 500px;">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="columnButtonFavoritos">Columna</button>
                    <ul class="dropdown-menu" id="columnDropdownFavoritos">
                        <!-- Los nombres de las columnas se agregarán aquí dinámicamente -->
                    </ul>
                    <input type="text" class="form-control" id="searchInputFavoritos" aria-label="Text input with dropdown button" placeholder="Buscar...">
                </div>
            </div>
            <div class="container-fluid" id="favoritosTablaContainer"></div>
            <div id="paginacionFavoritos" class="mt-3">
                <!-- Aquí se generarán los botones de paginación -->
            </div>
        </div>

        <div id="reservas" class="tabContent" style="display: none; height: 100%;">
            <h2 class="mb-4">Datos de reservas</h2>
            <div class="d-flex justify-content-center">
                <div class="input-group mb-3" style="max-width: 500px;">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="columnButtonReservas">Columna</button>
                    <ul class="dropdown-menu" id="columnDropdownReservas">
                        <!-- Los nombres de las columnas se agregarán aquí dinámicamente -->
                    </ul>
                    <input type="text" class="form-control" id="searchInputReservas" aria-label="Text input with dropdown button" placeholder="Buscar...">
                </div>
            </div>
            <div class="container-fluid" id="reservasTablaContainer"></div>
            <div id="paginacionReservas" class="mt-3">
                <!-- Aquí se generarán los botones de paginación -->
            </div>
        </div>

        <div id="usuarios" class="tabContent" style="display: none; height: 100%;">
            <h2 class="mb-4">Datos de usuarios</h2>
            <div class="d-flex justify-content-center">
                <div class="input-group mb-3" style="max-width: 500px;">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="columnButtonUsuarios">Columna</button>
                    <ul class="dropdown-menu" id="columnDropdownUsuarios">
                        <!-- Los nombres de las columnas se agregarán aquí dinámicamente -->
                    </ul>
                    <input type="text" class="form-control" id="searchInputUsuarios" aria-label="Text input with dropdown button" placeholder="Buscar...">
                </div>
            </div>
            <div class="container-fluid" id="usuariosTablaContainer"></div>
            <!-- Contenedor para la paginación -->
            <div id="paginacionUsuarios" class="mt-3">
                <!-- Aquí se generarán los botones de paginación -->
            </div>
        </div>

    </div>
</div>

<div class="toast-container position-fixed bottom-0 end-0 p-3" data-user-id="<?php echo $_SESSION['user_id']?>">
</div>

<?php
include("footer.php");
?>

<script src="js/admin_panel.js"></script>
<script src="js/admin_tables.js"></script>
<script src="js/notification.js" type="module"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
