<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include("funciones_BD.php");

$slugs = explode("-", $_SERVER['REQUEST_URI']);
$car = getCar($slugs[2]);
print_r($car);
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


<footer class="container-fluid text-center">
    <?php
    include ("footer.php");
    ?>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
