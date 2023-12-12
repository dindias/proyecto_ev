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
    <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/litepicker.js"></script>
    <script src="https://kit.fontawesome.com/305aef3688.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="info.css">
</head>
<body>

<header>
    <?php
    require("header.php");
    ?>
</header>

<!-- Formulario login -->
<?php
include("login.php");
?>

<!-- Formulario login -->
<?php
include("register.php");
?>

<!--Section: FAQ-->
<div class="container">
    <section>
        <h3 class="text-center mb-4 pb-2 text-primary fw-bold">Preguntas Frecuentes</h3>
        <p class="text-center mb-5">
            Encuentra las respuestas a las preguntas más frecuentes a continuación.
        </p>

        <div class="row">
            <div class="col-md-6 col-lg-4 mb-4">
                <h6 class="mb-3 text-primary"><i class="far fa-paper-plane text-primary pe-2"></i> ¿Cómo se trata la información de mis datos?</h6>
                <p>
                    Trabajamos con las principales empresas de pago para garantizar la seguridad de tus transacciones y la privacidad de tus datos. Toda la información de facturación se almacena de forma segura. Obtén más información <a class="text-blue" href="https://www.paypal.com/es/home">aquí</a>.
                </p>
            </div>

            <div class="col-md-6 col-lg-4 mb-4">
                <h6 class="mb-3 text-primary"><i class="fas fa-pen-alt text-primary pe-2"></i> ¿Cuáles son mis opciones de cancelación de suscripción al vehículo alquilado?</h6>
                <p>
                    Puedes cancelar tu suscripción al vehículo alquilado hasta 48 horas antes. Después de ese período, se aplicará un cargo por la gestión y puesta a punto del servicio.
                </p>
            </div>

            <div class="col-md-6 col-lg-4 mb-4">
                <h6 class="mb-3 text-primary"><i class="fas fa-user text-primary pe-2"></i> ¿Ofrecen opciones de suscripción mensual?</h6>
                <p>
                    Sí, actualmente solo ofrecemos suscripciones mensuales. Puedes actualizar o cancelar tu cuenta mensual en cualquier momento sin ninguna obligación adicional.
                </p>
            </div>

            <div class="col-md-6 col-lg-4 mb-4">
                <h6 class="mb-3 text-primary"><i class="fas fa-rocket text-primary pe-2"></i> ¿Cómo puedo actualizar mi información de pago?</h6>
                <p>
                    Puedes actualizar tu información de pago fácilmente yendo a la sección de facturación en tu panel de control.
                </p>
            </div>

            <div class="col-md-6 col-lg-4 mb-4">
                <h6 class="mb-3 text-primary"><i class="fas fa-home text-primary pe-2"></i> ¿Ofrecen reembolsos?</h6>
                <p><strong><u>Lamentablemente no.</u></strong> No emitimos reembolsos completos o parciales por ninguna razón una vez se ha entregado el vehículo a la persona que lo alquiló.</p>
            </div>

            <div class="col-md-6 col-lg-4 mb-4">
                <h6 class="mb-3 text-primary"><i class="fas fa-book-open text-primary pe-2"></i> ¿Ofrecen un plan gratuito de prueba?</h6>
                <p>
                    Actualmente no ofrecemos ningún plan gratuito para probar el servicio.
                </p>
            </div>
        </div>
    </section>
</div>

<div class="container mt-5">
    <h1 class="text-center mb-4">Tarificación y Precios</h1>

    <div class="accordion" id="priceAccordion">
        <div class="accordion-item">
            <h2 class="accordion-header" id="priceHeading">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#priceCollapse" aria-expanded="true" aria-controls="priceCollapse">
                    Precios y Tarificación
                </button>
            </h2>

            <div id="priceCollapse" class="accordion-collapse collapse" aria-labelledby="priceHeading" data-bs-parent="#priceAccordion">
                <div class="accordion-body">
                    <p>En Hispania EV, entendemos la importancia de la transparencia y la flexibilidad en el proceso de alquiler de coches híbridos y eléctricos. Nuestra estructura de precios está diseñada para brindarte opciones adaptadas a tus necesidades.</p>

                    <p>Los precios son establecidos por los anunciantes individuales, quienes son propietarios de los vehículos que ves en nuestra plataforma. Esto significa que cada vehículo puede tener su propia tarifa única y condiciones de alquiler específicas.</p>

                    <p>Al alquilar un coche, tendrás la flexibilidad de seleccionar los días específicos que deseas, permitiéndote adaptar el alquiler según tu agenda y preferencias. Nuestra plataforma facilita la comunicación directa entre los anunciantes y los clientes, para que puedas obtener información detallada sobre cualquier aspecto relacionado con la tarificación.</p>

                    <p>Queremos que disfrutes de una experiencia de alquiler sin complicaciones, por lo que te animamos a explorar los diferentes vehículos disponibles, comparar precios y condiciones, y encontrar la opción perfecta para tu viaje sostenible.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-5">
    <h1 class="text-center mb-4">Tratamiento de Privacidad y Cookies</h1>

    <!-- Acordeón para Tratamiento de Privacidad y Cookies -->
    <div class="accordion" id="privacyAccordion">
        <!-- Tratamiento de Privacidad -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="privacyHeading">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#privacyCollapse" aria-expanded="true" aria-controls="privacyCollapse">
                    Tratamiento de Privacidad
                </button>
            </h2>

            <div id="privacyCollapse" class="accordion-collapse collapse" aria-labelledby="privacyHeading" data-bs-parent="#privacyAccordion">
                <div class="accordion-body">
                    <p>En Hispania EV, nos tomamos en serio tu privacidad y nos esforzamos por garantizar la protección de tus datos personales. A continuación, te proporcionamos información detallada sobre cómo tratamos y protegemos tu privacidad:</p>

                    <h5>Recopilación de Información:</h5>
                    <p>Recopilamos información personal limitada y relevante que nos proporcionas directamente al utilizar nuestros servicios. Esta información puede incluir detalles de contacto, preferencias de alquiler y detalles de pago.</p>

                    <h5>Uso de la Información:</h5>
                    <p>Utilizamos la información recopilada para facilitar la reserva de vehículos, mejorar nuestros servicios y personalizar tu experiencia. Tus datos personales nunca se venderán ni compartirán con terceros no autorizados.</p>

                    <h5>Seguridad de Datos:</h5>
                    <p>Implementamos medidas de seguridad avanzadas para proteger tus datos contra accesos no autorizados, pérdida o alteración. Utilizamos tecnologías seguras para garantizar la transmisión segura de datos.</p>

                    <h5>Acceso y Control:</h5>
                    <p>Tienes derecho a acceder, corregir y eliminar tus datos personales. También puedes gestionar tus preferencias de comunicación y cookies en cualquier momento.</p>

                    <p>Al utilizar nuestros servicios, aceptas nuestro tratamiento de datos según se describe en nuestra política de privacidad.</p>
                </div>
            </div>
        </div>

        <!-- Política de Cookies -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="cookiesHeading">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#cookiesCollapse" aria-expanded="true" aria-controls="cookiesCollapse">
                    Política de Cookies
                </button>
            </h2>

            <div id="cookiesCollapse" class="accordion-collapse collapse" aria-labelledby="cookiesHeading" data-bs-parent="#privacyAccordion">
                <div class="accordion-body">
                    <p>Nuestra política de cookies tiene como objetivo brindarte una experiencia de usuario personalizada y eficiente al utilizar nuestro sitio web. A continuación, te explicamos cómo utilizamos las cookies y cómo puedes controlarlas:</p>

                    <h5>¿Qué son las Cookies?</h5>
                    <p>Las cookies son pequeños archivos de texto que se almacenan en tu dispositivo cuando visitas nuestro sitio web. Estas cookies nos ayudan a mejorar la funcionalidad y el rendimiento del sitio.</p>

                    <h5>Tipos de Cookies:</h5>
                    <p>Utilizamos cookies esenciales para el funcionamiento básico del sitio y cookies de análisis para comprender cómo interactúas con nuestro contenido. Las cookies publicitarias se utilizan para personalizar la publicidad según tus intereses.</p>

                    <h5>Control de Cookies:</h5>
                    <p>Tienes la opción de aceptar o rechazar cookies. Puedes modificar la configuración de cookies en tu navegador o dispositivo. Sin embargo, ten en cuenta que la desactivación de cookies puede afectar la funcionalidad de ciertas partes de nuestro sitio.</p>

                    <p>Al continuar utilizando nuestro sitio, aceptas el uso de cookies de acuerdo con nuestra política.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="toast-container position-fixed bottom-0 end-0 p-3" data-user-id="<?php echo $_SESSION['user_id']?>">
</div>

<!--Section: FAQ-->

<?php
include("footer.php");
?>

<script src="info.js"></script>
<script src="js/notification.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
