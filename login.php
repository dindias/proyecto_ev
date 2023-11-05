<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
?>
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Iniciar Sesión</h5>
            </div>
            <div class="modal-body">
                <form id="formulario_login" method="post" action="backend.php">
                    <input type="hidden" name="action" value="login">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña:</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                </form>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>
