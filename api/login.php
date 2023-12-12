<?php
error_reporting(E_ALL ^ E_NOTICE);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Iniciar Sesión</h5>
            </div>
            <div class="modal-body">
                <form id="formulario_login">
                    <input type="hidden" name="action" value="login">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña:</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div><br>

                    <!-- Alerta de éxito -->
                    <div id="loginSuccessAlert" class="alert alert-success d-none" role="alert"></div>

                    <!-- Alerta de error -->
                    <div id="loginErrorAlert" class="alert alert-danger d-none" role="alert"></div>

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="loginUser()">Iniciar Sesión</button>
                </form>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>

<script>
    function loginUser() {
        let formData = new FormData(document.getElementById('formulario_login'));
        formData.append('action', 'login');

        // Realiza la solicitud Fetch para enviar los datos al servidor de forma asíncrona
        fetch('backend.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                // Manejar la respuesta del servidor
                console.log(data);

                // Muestra un mensaje al usuario (éxito o error)
                if (data.status === 'success') {
                    document.getElementById('loginSuccessAlert').innerText = data.message;
                    document.getElementById('loginSuccessAlert').classList.remove('d-none');
                    document.getElementById('loginErrorAlert').classList.add('d-none');

                    // Cierra el modal solo si la respuesta indica éxito
                    var loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
                    loginModal.hide();
                    window.location.reload();
                } else {
                    document.getElementById('loginErrorAlert').innerText = data.message;
                    document.getElementById('loginErrorAlert').classList.remove('d-none');
                    document.getElementById('loginSuccessAlert').classList.add('d-none');
                }
            })
            .catch(error => {
                console.error('Error:', error);

                // Muestra un mensaje de error al usuario
                alert('Ocurrió un error al iniciar sesión');
            });
    }
</script>
