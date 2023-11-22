document.addEventListener('DOMContentLoaded', function () {
    // Supongamos que tienes una función para mostrar toasts de Bootstrap 5
    function showToast(message) {
        // Implementa la lógica para mostrar toasts aquí
        // Puedes usar librerías como Bootstrap Toast o implementar tu propio mecanismo
        console.log(message);
    }

    // Función para obtener notificaciones no leídas y mostrar toasts
    function checkAndShowNotifications() {
        let formData = new FormData();
        formData.append('case', 'checkNotificacion');
        // Llamada a la función para obtener notificaciones no leídas
        fetch('backend.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                // Verificar si hay notificaciones no leídas
                if (data.length > 0) {
                    // Mostrar cada notificación como toast
                    data.forEach(notification => {
                        showToast(notification.message);

                        // Llamada a la función para marcar la notificación como leída
                        fetch('ruta-al-backend/markNotificationAsRead.php?notificationID=' + notification.notificationID);
                    });
                }
            })
            .catch(error => {
                console.error('Error al obtener notificaciones:', error);
            });
    }

    // Llamada a la función para obtener y mostrar notificaciones al cargar la página
    // Asegúrate de tener el ID del usuario disponible (puedes obtenerlo desde el backend si es necesario)
    var userID = obtenerUserIDDesdeDondeSea(); // Reemplaza esto con tu lógica real para obtener el ID del usuario
    checkAndShowNotifications(userID);
});
