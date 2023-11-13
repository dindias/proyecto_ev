<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
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

<?php

if(isset($_GET['slug'])) {
    $slug = $_GET['slug'];
    $slugParts = explode('-', $slug);
    $carID = end($slugParts); // Asumimos que el CarID es la última parte del slug

    // Sanitizar el $carId antes de usarlo en una consulta a la base de datos para prevenir inyecciones SQL
    $carID = intval($carID);

    // Ahora puedes usar $carID para obtener los detalles del coche de la base de datos.
    $carDetails = getCarDetails($carID);
}

function getCarDetails($carID) {
    // ... tu función existente para obtener los detalles de un coche por su CarID ...
}

// A continuación, imprimirías los detalles del coche en HTML.
?>

<footer class="container-fluid text-center">
    <?php
    include ("footer.php");
    ?>
</footer>
<script src="coche.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
