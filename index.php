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
    <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/litepicker.js"></script>
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
        .card-header {
            background: linear-gradient(45deg, #6a11cb 0%, #2575fc 100%);
            color: white;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
            transition: 0.3s;
        }
        .card {
            border-radius: 15px;
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
    <div class="carousel-inner" style="max-height: 90vh">
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
    <div id="cars-container" class="row" style="margin-top: 1%">
        <!-- Los coches se cargarán aquí mediante JavaScript -->
    </div>

    <!-- Paginación -->
    <nav aria-label="Page navigation">
        <ul id="pagination" class="pagination justify-content-center">
            <!-- Los enlaces de paginación se generarán aquí mediante JavaScript -->
        </ul>
    </nav>
</div><br><br>

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
                                <input type="text" id="dateRangePicker" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                Condiciones del servicio
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree">
                            <div class="accordion-body">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Siguiente</button>
                </div>
            </div>
        </div>
    </div>
</div>


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
            <div class="card h-100 shadow" id="card${car.CarID}" style="border-radius: 15px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#detalles-coche" onclick="loadCarDetails(${JSON.stringify(car).split('"').join("&quot;")})">
                <div class="card-header" style="background-color: #f7f7f7; border-top-left-radius: 15px; border-top-right-radius: 15px;">
                    <h5 class="card-title text-wrap" style="color: #2575fc;"><b>${car.Marca} ${car.Modelo}</b></h5>
                </div>
                <img class="card-img-top" src="${car.imagenes}" alt="Card image cap" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                <div class="card-body">
                    <p class="card-text text-wrap">
                        <strong>Año:</strong> ${car.Ano}<br>
                        <strong>Kilometraje:</strong> ${car.Kilometraje}<br>
                        <strong>Descripción:</strong> ${car.Descripcion}<br>
                        <strong style="color: #28a745;">Precio:</strong> ${car.Precio}
                    </p>
                </div>
            </div>
        </div>
    `).join('');
    }

    var modalElement = document.getElementById('detalles-coche');

    if (modalElement) {
        modalElement.addEventListener('hidden.bs.modal', function () {
            // Comprueba si el cuerpo tiene la clase 'modal-open' y la elimina
            document.body.classList.remove('modal-open');

            // Elimina las propiedades 'overflow' y 'padding-right' estilo directamente en el body, si existen
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';

            // Elimina el modal backdrop si existe
            var backdrops = document.querySelectorAll('.modal-backdrop');
            backdrops.forEach(function(backdrop) {
                backdrop.remove();
            });
        });
    }

    function loadCarDetails(car) {
        // Actualizar el contenido del modal con los detalles del coche
        document.getElementById('carImage').src = car.imagenes;
        document.getElementById('carTitle').textContent = car.Marca + ' ' + car.Modelo;
        document.getElementById('carYear').textContent = `Año: ${car.Ano}`;
        document.getElementById('carMileage').textContent = `Kilometraje: ${car.Kilometraje}`;
        document.getElementById('carDescription').textContent = `Descripción: ${car.Descripcion}`;
        document.getElementById('carPrice').textContent = `Precio: ${car.Precio}`;

        // Abrir el modal con Bootstrap JavaScript API (asumiendo que usas Bootstrap 5)
        const modalElement = document.getElementById('detalles-coche');
        const modal = new bootstrap.Modal(modalElement);

        // Verificar si el modal se inicializó correctamente antes de abrirlo
        if(modal) {
            modal.show();
        }
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

    document.addEventListener('DOMContentLoaded', function () {
        var picker = new Litepicker({
            element: document.getElementById('dateRangePicker'),
            singleMode: false,
            allowRepick: true,
            onSelect: function(start, end) {
                console.log(start, end);
            }
        });
    });

</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
