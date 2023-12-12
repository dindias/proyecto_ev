<?php

if (!isset($_COOKIE['cookie_accepted'])) {
    // Si no está configurada, mostrar el mensaje de popup
    echo '<div class="cookie-popup" id="cookiePopup">
            Este sitio web utiliza cookies para mejorar la experiencia del usuario.
            <button class="cookie-popup-btn" onclick="acceptCookies()">Aceptar Cookies</button>
          </div>';
}
?>
<script>
    function acceptCookies() {
        // Establecer la cookie con una duración de 30 días (puedes ajustar esto según tus necesidades)
        document.cookie = "cookie_accepted=true; expires=" + new Date(new Date().getTime() + 30 * 24 * 60 * 60 * 1000).toUTCString() + "; path=/";

        // Ocultar el popup
        document.getElementById("cookiePopup").style.display = "none";
    }
</script>