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
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        /* Remove the navbar's default rounded borders and increase the bottom margin */
        .navbar {
            margin-bottom: 50px;
            border-radius: 0;
        }
        .filtro-coches{
            position: sticky;
            top: 0;
        }

        .navbar-inverse {
            margin-top: 1%;
        }

        /* Add a gray background color and some padding to the footer */
        footer {
            background-color: #f2f2f2;
            padding: 25px;
        }
        .carousel-inner {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .carousel-inner > .item > img {
            width: 100vw;
            height: 100vh;
            object-fit: cover;
        }
        .container {
            width: 50%; /* O el ancho que prefieras */
            height: 70%; /* O el ancho que prefieras */
        }

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

<div class="container-fluid">  <!-- contenedor full-width -->
    <div class="row">   <!-- nueva fila -->
        <div class="col-xs-12">  <!-- columna de ancho completo -->
            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                    <li data-target="#myCarousel" data-slide-to="2"></li>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner">
                    <div class="item active justify-content-center min-vh-100">
                        <img src="img/turismo_ID.png" alt="Volkswagen ID.4">
                    </div>
                </div>

                <!-- Left and right controls -->
                <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#myCarousel" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <nav class="navbar navbar-inverse filtro-coches">
            <ul class="nav navbar-nav">

                <!-- Marca -->
                <li class="filtro dropdown" data-filtro="marca">
                    <a href="#" onclick="return false;" class="dropdown-toggle" data-toggle="dropdown">Marca<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#" onclick="return false;">Sin filtro</a></li>
                        <?php
                        $marcas = get_unique_values('Marca', 'coches');
                        foreach($marcas as $marca):
                            ?>
                            <li><a href="#" onclick="return false;"><?php echo $marca; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>

                <!-- Modelo -->
                <li class="filtro dropdown" data-filtro="modelo">
                    <a href="#" onclick="return false;" class="dropdown-toggle" data-toggle="dropdown">Modelo<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#" onclick="return false;">Sin filtro</a></li>
                        <?php
                        $modelos = get_unique_values('Modelo', 'coches');
                        foreach($modelos as $modelo):
                            ?>
                            <li><a href="#" onclick="return false;"><?php echo $modelo; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>

                <!-- Año -->
                <!-- Recuerda cambiar el valor del atributo data-filtro a 'ano' -->
                <li class="filtro dropdown" data-filtro="ano">
                    <a href="#" onclick="return false;" class="dropdown-toggle" data-toggle="dropdown">Año<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#" onclick="return false;">Sin filtro</a></li>
                        <?php
                        $anos = get_unique_values('Año', 'coches');
                        foreach($anos as $ano):
                            ?>
                            <li><a href="#" onclick="return false;"><?php echo $ano; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>

                <!-- Kilometraje -->
                <!-- Recuerda cambiar el valor del atributo data-filtro a 'kilometraje' -->
                <li class="filtro dropdown" data-filtro="kilometraje">
                    <a href="#" onclick="return false;" class="dropdown-toggle" data-toggle="dropdown">Kilometraje<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#" onclick="return false;">Sin filtro</a></li>
                        <?php
                        $kilometros = get_unique_values('Kilometraje', 'coches');
                        foreach($kilometros as $kilometro):
                            ?>
                            <li><a href="#" onclick="return false;" onclick="return false;"><?php echo $kilometro; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>

                <!-- Precio -->
                <!-- Recuerda cambiar el valor del atributo data-filtro a 'precio' -->
                <li class="filtro dropdown" data-filtro="precio">
                    <a href="#" onclick="return false;" class="dropdown-toggle" data-toggle="dropdown">Precio<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#" onclick="return false;" onclick="return false;">Sin filtro</a></li>
                        <?php
                        $precios = get_unique_values('Precio', 'coches');
                        foreach($precios as $precio):
                            ?>
                            <li><a href="#" onclick="return false;"><?php echo $precio; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>

<div class="container">
    <div class="row">
        <?php
        $counter = 0;
        $cars = getCars(); // Obtiene los coches de la base de datos

        foreach($cars as $car)
        {
        if($counter != 0 && $counter % 4 == 0){
        ?>
    </div>
    <div class="row">
        <?php
        }
        ?>
        <div class="col-sm-3">
            <div class="panel panel-primary">
                <div class="panel-heading"><?php echo $car['Marca'] . " " . $car['Modelo']; ?></div>
                <div class="panel-body"><?php echo '<img src="https://placehold.it/150x80?text=' . $car['Matricula'] . '" class="img-responsive" style="width:100%" alt="Image">' ?></div>
                <div class="panel-footer"><?php echo $car['Descripcion']; ?></div>
            </div>
        </div>
        <?php
        $counter++;
        }
        ?>
    </div>
</div><br><br>

<script>
    $('.filtro .dropdown-menu li a').click(function(e) {
        e.preventDefault();

        var filtro = $(this).closest('.filtro').data('filtro');
        var valor = $(this).text();

        $.ajax({
            url: 'backend.php',
            type: 'POST',
            data: {
                action: 'filtro_coches',
                filters: { [filtro]: valor }
            },
            success: function(response) {
                $('.container').html(response);
            }
        });
    });

    //Botón de logout
    document.addEventListener("DOMContentLoaded", function() {
        var logoutlink = document.getElementById("logoutlink");

        if(logoutlink) {
            logoutlink.addEventListener("click", function(event) {
                // Prevenir comportamiento por defecto del link
                event.preventDefault();

                var xhr = new XMLHttpRequest();
                xhr.open("POST", "backend.php", false); // `false` hace que la solicitud sea síncrona
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        // La petición se ha completado satisfactoriamente.
                        console.log(xhr.responseText);

                        // Redirección al index.php
                        window.location.href = 'index.php';
                    }
                };
                xhr.send("action=logout");
            });
        }
    });

</script>
<footer class="container-fluid text-center">
    <?php
    include ("footer.php");
    ?>
</footer>

</body>
</html>
