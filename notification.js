document.addEventListener('DOMContentLoaded', function () {
    // Supongamos que tienes una función para mostrar toasts de Bootstrap 5
    function showToast(message, notificationID) {
        // Crear el elemento de toast
        var toast = document.createElement('div');
        toast.classList.add('toast');
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');
        toast.setAttribute('aria-atomic', 'true');
        toast.setAttribute('data-bs-autohide', 'true');

        // Crear el encabezado del toast
        var toastHeader = document.createElement('div');
        toastHeader.classList.add('toast-header');
        toast.appendChild(toastHeader);

        toastHeader.innerHTML = `
        <strong class="me-auto">Notificación</strong>
        <small class="text-muted">${getCurrentTime()}</small>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    `;

        // Crear el cuerpo del toast
        var toastBody = document.createElement('div');
        toastBody.classList.add('toast-body');
        toastBody.textContent = message;
        toast.appendChild(toastBody);

        // Agregar el toast al contenedor
        var toastContainer = document.querySelector('.toast-container');
        toastContainer.appendChild(toast);

        // Inicializar el objeto Toast de Bootstrap
        var bootstrapToast = new bootstrap.Toast(toast);

        // Mostrar el toast
        bootstrapToast.show();

        var closeButton = toast.querySelector('.btn-close');
        closeButton.addEventListener('click', function() {
            markNotificationAsRead(notificationID);
        });
    }

// Función para marcar la notificación como leída
    function markNotificationAsRead(notificationID) {
        let markNotificationFormData = new FormData();
        markNotificationFormData.append('action', 'markNotification');
        markNotificationFormData.append('notificationID', notificationID);

        fetch('backend.php', {
            method: 'POST',
            body: markNotificationFormData
        })
            .then(markResponse => markResponse.json())
            .then(markData => {
                // Puedes realizar acciones adicionales después de marcar la notificación como leída, si es necesario.
            })
            .catch(markError => {
                console.error('Error al marcar notificación como leída:', markError);
            });
    }

// Función para obtener la hora actual en formato hh:mm:ss
    function getCurrentTime() {
        var now = new Date();
        var hours = now.getHours().toString().padStart(2, '0');
        var minutes = now.getMinutes().toString().padStart(2, '0');
        var seconds = now.getSeconds().toString().padStart(2, '0');
        return `${hours}:${minutes}:${seconds}`;
    }


    // Función para obtener notificaciones no leídas y mostrar toasts
    function checkAndShowNotifications(userID) {
        let formData = new FormData();
        formData.append('action', 'checkNotificacion');
        formData.append('userID', userID);

        // Llamada a la función para obtener notificaciones no leídas
        fetch('backend.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                // Verificar si hay notificaciones no leídas
                if (data.length > 0) {
                    updateNotificationsBellIcon(data);
                    data.forEach(notification => {
                        showToast(notification.Message, notification.NotificationID);
                    });
                }
            })
            .catch(error => {
                console.error('Error al obtener notificaciones:', error);
            });
    }

    var userID = document.querySelector('.toast-container').dataset.userId;
    checkAndShowNotifications(userID);

    function updateNotificationsBellIcon(notifications) {
        console.log(notifications);
        var hasUnreadNotifications = notifications.some(notification => notification.IsRead !== 1);

        var notificationsBell = document.getElementById('notificationBell');
        if (notificationsBell) {
            notificationsBell.classList.remove('fa-regular', 'fa-solid', 'fa-shake', 'fa-xl', 'ms-2');

            if (hasUnreadNotifications) {
                notificationsBell.classList.add('fa-solid', 'fa-bell', 'fa-xl', 'ms-2', 'fa-shake');
            } else {
                notificationsBell.classList.add('fa-regular', 'fa-bell', 'fa-xl', 'ms-2');
            }
        }
    }
});
