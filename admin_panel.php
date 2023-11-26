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

<!-- Formulario registro -->
<?php
include ("register.php");
?>
<!-- Resto del body aquí -->

<div class="container-flex">
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
        </div>

        <div id="favoritos" class="tabContent" style="display: none; height: 100%;">
            <h2 class="mb-4">Datos de favoritos</h2>
        </div>

        <div id="reservas" class="tabContent" style="display: none; height: 100%;">
            <h2 class="mb-4">Datos de reservas</h2>
        </div>

        <div id="usuarios" class="tabContent" style="display: none; height: 100%;">
            <h2 class="mb-4">Datos de usuarios</h2>
        </div>

    </div>
</div>
<div class="toast-container position-fixed bottom-0 end-0 p-3" data-user-id="<?php echo $_SESSION['user_id']?>">
</div>

<?php
include ("footer.php");
?>

<script src="admin_panel.js"></script>
<script src="notification.js" type="module"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
