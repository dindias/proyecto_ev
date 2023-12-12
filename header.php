<?php
error_reporting(E_ALL ^ E_NOTICE);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }

    .cookie-popup {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background-color: #333;
        color: #fff;
        text-align: center;
        padding: 10px;
        display: none;
    }

    .cookie-popup-btn {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
</style>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="img/logo.jpg" alt="Hispania EV logo" class="img-fluid" width="30" height="30">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#myNavbar" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="busqueda.php">Alquilar</a></li>
                <li class="nav-item"><a class="nav-link" href="info.php">Sobre nosotros</a></li>
            </ul>
            <!-- Dropdown -->
            <?php if (isset($_SESSION['user_id']) && isAdmin($_SESSION['user_id'])) {?>
                <button type="button" class="btn btn-info" id="adminPanelButton" style="margin-right: 5px;">Panel de administrador</button>
            <?php }?>
            <?php if(isset($_SESSION['user_id'])):?>
                <li class="nav-item dropdown d-flex align-items-center">
                        <a href="control_panel.php#notificaciones" class="btn btn-light position-relative" style="margin-right: 15px;">
                            <i id="notificationBell" class="far fa-bell fa-lg"></i>
                                <?php
                                    $unreadNotifications = count(getUnreadNotifications($_SESSION['user_id']));
                                    if ($unreadNotifications > 0) {?>
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    <?php
                                    echo $unreadNotifications;
                                ?>
                                <span class="visually-hidden">unread notifications</span>
                                <?php }?>
                            </span>
                        </a>
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo $_SESSION['nombre']; ?>
                    </a>
                    <!-- Campana de notificaciones -->
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="control_panel.php">Panel de control</a></li>
                        <li><a class="dropdown-item" id="logoutlink" href="#">Cerrar sesión</a></li>
                    </ul>
                </li>
            <?php else: ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Tu cuenta
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a></li>
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#registerModal">Registrarse</a></li>
                    </ul>
                </li>
            <?php endif; ?>
        </div>
    </div>
</nav>

<script>

    document.getElementById('adminPanelButton').addEventListener('click', function() {
        // Redirige a admin_panel.php
        window.location.href = 'admin_panel.php';
    });

    document.addEventListener('DOMContentLoaded', (event) => {
        document.getElementById('logoutlink').addEventListener('click', function(e){
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


