<?php
error_reporting(E_ALL ^ E_NOTICE);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<style>
    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        margin: 0;
    }

    footer {
        margin-top: auto;
    }
</style>
<!-- Remove the container if you want to extend the Footer to full width. -->
    <!-- Footer -->
<br><footer
        class="text-center text-lg-start text-white"
        style="background-color: #45526e"
>
    <!-- Grid container -->
    <div class="container p-4 pb-0">
        <!-- Section: Links -->
        <section class="">
            <!--Grid row-->
            <div class="row">
                <!-- Grid column -->
                <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                    <h6 class="text-uppercase mb-4 font-weight-bold">
                        Hispania EV
                    </h6>
                    <p class="text-wrap">
                        Donde sostenibilidad y movimiento se unen.
                    </p>
                </div>
                <!-- Grid column -->

                <hr class="w-100 clearfix d-md-none" />

                <!-- Grid column -->
                <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
                    <h6 class="text-uppercase mb-4 font-weight-bold">Productos</h6>
                    <p>
                        <i class="fa-solid fa-magnifying-glass"></i> <a class="text-white">Busqueda</a>
                    </p>
                    <p>
                        <i class="fa-solid fa-money-bills"></i> <a class="text-white">Precios</a>
                    </p>
                </div>
                <!-- Grid column -->

                <hr class="w-100 clearfix d-md-none" />

                <!-- Grid column -->
                <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mt-3">
                    <h6 class="text-uppercase mb-4 font-weight-bold">
                        Utilidad
                    </h6>
                    <p>
                        <i class="fa-solid fa-user"></i> <a class="text-white" href="control_panel.php">Tu cuenta</a>
                    </p>
                    <p>
                        <i class="fa-solid fa-tags"></i> <a class="text-white">Alquila con nosotros</a>
                    </p>
                    <p>
                        <i class="fa-solid fa-clipboard-question"></i> <a class="text-white" href="info.php">Preguntas frecuentes</a>
                    </p>
                    <p>
                        <i class="fa-solid fa-handshake-angle"></i> <a class="text-white" href="info.php">Ayuda</a>
                    </p>
                </div>

                <!-- Grid column -->
                <hr class="w-100 clearfix d-md-none" />

                <!-- Grid column -->
                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
                    <h6 class="text-uppercase mb-4 font-weight-bold">Contacto</h6>
                    <p><i class="fas fa-home mr-3"></i> Mérida, C/ Comarca de las Hurdes nº4</p>
                    <p><i class="fas fa-envelope mr-3"></i> daniel@gmail.com</p>
                    <p><i class="fas fa-phone mr-3"></i> + 34 691 247 365</p>
                </div>
                <!-- Grid column -->
            </div>
            <!--Grid row-->
        </section>
        <!-- Section: Links -->

        <hr class="my-3">

        <!-- Section: Copyright -->
        <section class="p-3 pt-0">
            <div class="row d-flex align-items-center">
                <!-- Grid column -->
                <div class="col-md-7 col-lg-8 text-center text-md-start">
                    <!-- Copyright -->
                    <div class="p-3">
                        © 2023 Copyright:
                        <a class="text-white" href="https://hispaniaev.com/"
                        >HispaniaEv.com</a
                        >
                    </div>
                    <!-- Copyright -->
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-5 col-lg-4 ml-lg-0 text-center text-md-end">
                    <!-- Facebook -->
                    <a
                            class="btn btn-outline-light btn-floating m-1"
                            class="text-white"
                            role="button"
                    ><i class="fab fa-facebook-f"></i
                        ></a>

                    <!-- Twitter -->
                    <a
                            class="btn btn-outline-light btn-floating m-1"
                            class="text-white"
                            role="button"
                    ><i class="fab fa-twitter"></i
                        ></a>

                    <!-- Google -->
                    <a
                            class="btn btn-outline-light btn-floating m-1"
                            class="text-white"
                            role="button"
                    ><i class="fab fa-google"></i
                        ></a>

                    <!-- Instagram -->
                    <a
                            class="btn btn-outline-light btn-floating m-1"
                            class="text-white"
                            role="button"
                    ><i class="fab fa-instagram"></i
                        ></a>
                </div>
                <!-- Grid column -->
            </div>
        </section>
        <!-- Section: Copyright -->
    </div>
    <!-- Grid container -->
</footer>
    <!-- Footer -->
<!-- End of .container -->