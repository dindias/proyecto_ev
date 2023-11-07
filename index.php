<?php
session_start();
include("funciones_BD.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Hispania EV</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        /* Remove the navbar's default rounded borders and increase the bottom margin */
        .navbar {
            border-radius: 0;
        }
        .filtro-coches{
            position: sticky;
            top: 0;
        }

        /* Add a gray background color and some padding to the footer */
        footer {
            background-color: #f2f2f2;
            padding: 25px;
        }

        .container {
            overflow-x: auto;
            white-space: nowrap;
        }

        .grid {
            display: flex;
            flex-wrap: wrap;
        }

        .cell {
            flex: 0 0 calc(33.333% - 10px);
            margin: 5px;
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

<div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="img/turismo_ID.png" class="d-block w-100" alt="...">
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

<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <!-- Marca -->
                <li class="nav-item dropdown filtro" data-filtro="marca">
                    <a class="nav-link dropdown-toggle" href="#" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">Marca</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Sin filtro</a></li>
                        <?php
                        $marcas = get_unique_values('Marca', 'coches');
                        foreach($marcas as $marca):
                            ?>
                            <li><a class="dropdown-item" href="#"><?php echo $marca; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>

                <!-- Modelo -->
                <li class="nav-item dropdown filtro" data-filtro="modelo">
                    <a class="nav-link dropdown-toggle" href="#" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">Modelo</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Sin filtro</a></li>
                        <?php
                        $modelos = get_unique_values('Modelo', 'coches');
                        foreach($modelos as $modelo):
                            ?>
                            <li><a class="dropdown-item" href="#"><?php echo $modelo; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>

                <!-- Año -->
                <li class="nav-item dropdown filtro" data-filtro="ano">
                    <a class="nav-link dropdown-toggle" href="#" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">Año</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Sin filtro</a></li>
                        <?php
                        $anos = get_unique_values('Año', 'coches');
                        foreach($anos as $ano):
                            ?>
                            <li><a class="dropdown-item" href="#"><?php echo $ano; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>

                <!-- Kilometraje -->
                <li class="nav-item dropdown filtro" data-filtro="kilometraje">
                    <a class="nav-link dropdown-toggle" href="#" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">Kilometraje</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Sin filtro</a></li>
                        <?php
                        $kilometros = get_unique_values('Kilometraje', 'coches');
                        foreach($kilometros as $kilometro):
                            ?>
                            <li><a class="dropdown-item" href="#"><?php echo $kilometro; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>

                <!-- Precio -->
                <li class="nav-item dropdown filtro" data-filtro="precio">
                    <a class="nav-link dropdown-toggle" href="#" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">Precio</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Sin filtro</a></li>
                        <?php
                        $precios = get_unique_values('Precio', 'coches');
                        foreach($precios as $precio):
                            ?>
                            <li><a class="dropdown-item" href="#"><?php echo $precio; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>



<div class="container">
    <div class="grid">
        <?php
        $cars = getCars();
        foreach($cars as $car) {
            ?>
            <div class="card m-3" style="width: 18rem;" id="card<?php echo $car['CarID']; ?>">
                <img class="card-img-top" src="<?php echo $car['imagenes']; ?>" alt="Card image cap" width="200px">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $car['Marca'] . " " . $car['Modelo']; ?></h5>
                    <p class="card-text">
                        Año: <?php echo $car['Año']; ?><br>
                        Kilometraje: <?php echo $car['Kilometraje']; ?><br>
                        Descripción: <?php echo $car['Descripcion']; ?><br>
                        Precio: <?php echo $car['Precio']; ?>
                    </p>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div><br><br>



<footer class="container-fluid text-center">
    <?php
    include ("footer.php");
    ?>
</footer>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var filtros_activos = {};   // Objeto para almacenar los filtros activos

        document.querySelectorAll('.filtro .dropdown-menu li a').forEach(function(element) {
            element.addEventListener('click', function(e) {
                e.preventDefault();

                var filtro = this.closest('.filtro').getAttribute('data-filtro');
                var valor = this.textContent;

                filtros_activos[filtro] = valor; // Actualizar el objeto de filtros activos

                fetch('backend.php', {
                    method: 'POST',
                    headers: {
                        'Content-type': 'application/x-www-form-urlencoded; charset=UTF-8'
                    },
                    body: `action=filtro_coches&filters=${encodeURIComponent(JSON.stringify(filtros_activos))}`  // Enviar todos los filtros activos
                })
                    .then(response => response.text())
                    .then(response => {
                        document.querySelector('.container').innerHTML = response;
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
    });



    //Botón de logout
    document.addEventListener('DOMContentLoaded', (event) => {
        document.getElementById('logoutlink').addEventListener('click', function(e){
            console.log("hola");
            e.preventDefault();

            fetch('backend.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    'action': 'logout'
                })
            })
                .then(response => response.text())
                .then(data => {
                    console.log(data)

                    // Recargar la página
                    location.reload();
                })
                .catch(error => console.error('Error:', error));
        });
    });

</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
