<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
?>
<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Logo</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li><a href="#">Alquilar</a></li>
                <li><a href="#">Modelos</a></li>
                <li><a href="#">Sobre nosotros</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <!-- Dropdown -->
                <?php if(isset($_SESSION['user_id'])): ?>
                    <li class="nav-item dropdown">
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button"
                                    data-toggle="dropdown"><?php echo $_SESSION['nombre']; ?>
                                <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li><a href="control_panel.php">Panel de control</a></li>
                                <li><a id="logoutlink" href="#">Cerrar sesión</a></li>
                            </ul>
                        </div>
                    </li>
                <?php else: ?>
                    <li class="nav-item dropdown">
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button"
                                    data-toggle="dropdown">Tu cuenta
                                <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li><a href="#" data-toggle="modal" data-target="#loginModal">Login</a></li>
                                <li><a href="#" data-toggle="modal" data-target="#registerModal">Registrarse</a></li>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
