<?php
session_start();
include("funciones_BD.php");
echo '<pre>';
var_dump($_SESSION);
echo '</pre>';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Panel de control</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
¡
        /* Add a gray background color and some padding to the footer */
        footer {
            background-color: #f2f2f2;
            padding: 25px;

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

<ul class="nav nav-tabs">
    <li class="active"><a href="#perfil" onclick="showTab('perfil'); return false;">Perfil</a></li>
    <li><a href="#anuncios" onclick="showTab('anuncios'); return false;">Anuncios</a></li>
    <li><a href="#historial" onclick="showTab('historial'); return false;">Historial</a></li>
</ul>


<div id="perfil" class="tabContent">
    <div class="container">
        <h2>Actualizar Perfil</h2>
        <form action="backend.php" method="post">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" placeholder="Introduce nuevo nombre" name="nombre">
            </div>
            <div class="form-group">
                <label for="apellido">Apellido:</label>
                <input type="text" class="form-control" id="apellido" placeholder="Introduce nuevo apellido" name="apellido">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" placeholder="Introduce nuevo email" name="email">
            </div>
            <div class="form-group">
                <label for="nacimiento">Nacimiento:</label>
                <input type="date" class="form-control" id="nacimiento" name="nacimiento">
            </div>
            <div class="form-group">
                <label for="numeroCuenta">Número de cuenta:</label>
                <input type="text" class="form-control" id="numeroCuenta" placeholder="Introduce nuevo número de cuenta" name="numeroCuenta">
            </div>
            <div class="form-group">
                <label for="direccion">Dirección:</label>
                <input type="text" class="form-control" id="direccion" placeholder="Introduce nueva dirección" name="direccion">
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" class="form-control" id="password" placeholder="Introduce nueva contraseña" name="password">
            </div>
            <button type="submit" class="btn btn-default">Actualizar</button>
        </form>
    </div>
</div>
<div id="anuncios" class="tabContent" style="display: none;">
    <!-- Aquí va el código para anuncios -->
</div>
<div id="historial" class="tabContent" style="display: none;">
    <!-- Aquí va el código para historial -->
</div>



<footer class="container-fluid text-center">
    <?php
    include ("footer.php");
    ?>
</footer>
<script>
    //Mostrar ventanas panel de control
    function showTab(tabId) {
        // Oculta todas las pestañas primero
        var tabs = document.getElementsByClassName('tabContent');
        for (var i = 0; i < tabs.length; i++) {
            tabs[i].style.display = 'none';
        }
        // Muestra la pestaña seleccionada
        document.getElementById(tabId).style.display = 'block';
        // Obtén todos los elementos li
        var liTabs = document.querySelectorAll(".nav li");
        // Recorre cada elemento li y elimina la clase active
        for (var i = 0; i < liTabs.length; i++) {
            liTabs[i].classList.remove("active");
        }
        // Añade la clase active al tab actual (el que ha sido seleccionado)
        var activeTab = document.querySelector(".nav a[href='#" + tabId + "']").parentNode;
        activeTab.classList.add("active");
    }


    //Modificación tabla usuarios
    $('#perfil form').on('submit', function(e) {
        e.preventDefault();

        // Recogemos los datos del formulario
        var formData = $(this).serializeArray();

        formData.push({
            name: "action",
            value: "modificar_perfil"
        });

        $.ajax({
            url: 'backend.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                $('.container').html(response);

                // Recarga la página después de un éxito en la petición ajax
                window.location.href = 'control_panel.php';
            }
        });
    });


</script>
</body>
</html>
