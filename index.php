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
    <style>
        /* Remove the navbar's default rounded borders and increase the bottom margin */
        .navbar {
            border-radius: 0;
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
                <li class="nav-item dropdown filtro" data-filtro="Ano">
                    <a class="nav-link dropdown-toggle" href="#" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">Año</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Sin filtro</a></li>
                        <?php
                        $anos = get_unique_values('Ano', 'coches');
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
    <div id="cars-container" class="row">
        <!-- Los coches se cargarán aquí mediante JavaScript -->
    </div>

    <!-- Paginación -->
    <nav aria-label="Page navigation">
        <ul id="pagination" class="pagination justify-content-center">
            <!-- Los enlaces de paginación se generarán aquí mediante JavaScript -->
        </ul>
    </nav>
</div><br><br>


<footer class="container-fluid text-center">
    <?php
    include ("footer.php");
    ?>
</footer>
<script>

    document.addEventListener('DOMContentLoaded', function() {
        loadCars(1); // Carga inicial de coches
    });

    function loadCars(page) {
        let formData = new FormData();
        formData.append('page', page);
        formData.append('action', 'paginate_cars');

        // Recoger los valores de los filtros actuales
        document.querySelectorAll('.filtro').forEach(filtro => {
            const key = filtro.getAttribute('data-filtro');
            const value = filtro.dataset.value;

            // Agregar sólo si value no es null
            if (value && value !== "null") {
                formData.append(key, value);
            }
        });

        fetch('backend.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                document.getElementById('cars-container').innerHTML = generateCarsHTML(data.cars);
                updatePagination(data.totalPages, page);
            })
            .catch(error => console.error('Hubo un error al cargar los coches:', error));
    }

    function generateCarsHTML(cars) {
        return cars.map(car => `
        <div class="col-md-3 col-sm-6 col-xs-12 mb-4">
            <div class="card" id="card${car.CarID}">
                <img class="card-img-top" src="${car.imagenes}" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">${car.Marca} ${car.Modelo}</h5>
                    <p class="card-text">
                        Año: ${car.Ano}<br>
                        Kilometraje: ${car.Kilometraje}<br>
                        Descripción: ${car.Descripcion}<br>
                        Precio: ${car.Precio}
                    </p>
                </div>
            </div>
        </div>
    `).join('');
    }

    function updatePagination(totalPages, currentPage) {
        let paginationHTML = '';
        for (let i = 1; i <= totalPages; i++) {
            paginationHTML += `<li class="page-item ${currentPage == i ? 'active' : ''}">
        <a class="page-link" href="#" onclick="loadCars(${i}); return false;">${i}</a>
    </li>`;
        }
        document.getElementById('pagination').innerHTML = paginationHTML;
    }

    function onFilterItemSelected(event) {
        event.preventDefault(); // Esto previene el comportamiento por defecto del enlace, que es navegar hacia el "#".

        // Asegúrate de que el evento sea manejado solo si se desencadena en elementos esperados
        if (!event.target.matches('.dropdown-item')) {
            return;
        }

        const filtroElem = event.target.closest('.filtro');
        const filtroValue = event.target.textContent.trim(); // Usar trim() para eliminar espacios en blanco

        // Procede solo si filtroElem no es null.
        if (filtroElem) {
            // Restablecer todos los filtros si se selecciona 'Sin filtro' o aplicar el filtro seleccionado
            if (filtroElem) {
                // Restablecer todos los filtros si se selecciona 'Sin filtro'
                if (filtroValue === 'Sin filtro') {
                    delete filtroElem.dataset.value; // Elimina la propiedad value del dataset, en lugar de asignarle null
                } else {
                    filtroElem.dataset.value = filtroValue;
                }

                loadCars(1); // Cargar los coches aplicando los filtros actuales
            } else {
                // Manejo de errores o registro opcional para situaciones inesperadas
                console.error('onFilterItemSelected: filtroElem is null');
            }
        }
    }

    // Asegúrate de que cada elemento que actúa como un filtro llame a esta función en su evento de clic
    document.querySelectorAll('.filtro .dropdown-item').forEach(function(item) {
        item.addEventListener('click', onFilterItemSelected);
    });

</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
