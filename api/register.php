<?php
error_reporting(E_ALL ^ E_NOTICE);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registro</h5>
            </div>
            <div class="modal-body">
                <form id="formulario_registro">
                    <input type="hidden" name="action" value="registro">
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="apellido">Apellido:</label>
                        <input type="text" class="form-control" id="apellido" name="apellido" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="nacimiento">Fecha de Nacimiento:</label>
                        <input type="date" class="form-control" id="nacimiento" name="nacimiento" required>
                    </div>
                    <div class="form-group">
                        <label for="direccion">Dirección:</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirmar Contraseña:</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        <small id="password_match_error" class="text-danger"></small>
                    </div><br>

                    <div id="registerSuccessAlert" class="alert alert-success d-none" role="alert"></div>

                    <div id="registerErrorAlert" class="alert alert-danger d-none" role="alert"></div>

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="registerUser()">Registrarse</button>
                </form>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>

<script>
    function registerUser() {
        var formData = new FormData(document.getElementById('formulario_registro'));
        formData.append('action', 'registro');

        // Realiza la solicitud Fetch para enviar los datos al servidor de forma asíncrona
        fetch('backend.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                // Manejar la respuesta del servidor
                console.log(data);

                // Cierra el modal solo si la respuesta indica éxito
                if (data.status === 'success') {
                    document.getElementById('registerSuccessAlert').innerText = data.message;
                    document.getElementById('registerSuccessAlert').classList.remove('d-none');
                    document.getElementById('registerErrorAlert').classList.add('d-none');
                    var registerModal = new bootstrap.Modal(document.getElementById('registerModal'));
                    registerModal.hide();
                    window.location.reload();
                } else {
                    document.getElementById('registerErrorAlert').innerText = data.message;
                    document.getElementById('registerErrorAlert').classList.remove('d-none');
                    document.getElementById('registerSuccessAlert').classList.add('d-none');
                }
            })
            .catch(error => {
                console.error('Error:', error);

                // Muestra un mensaje de error al usuario
                alert('Ocurrió un error al registrar el usuario');
            });
    }
</script>