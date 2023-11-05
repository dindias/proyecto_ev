<?php

session_start();

include("funciones_BD.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];

    switch($action) {
        case 'registro':
        {
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $email = $_POST['email'];
            $nacimiento = $_POST['nacimiento'];
            $direccion = $_POST['direccion'];
            $password = $_POST['password'];

            // Llama a la función registrarUsuario()
            registrarUsuario($nombre, $apellido, $email, $nacimiento, $direccion, $password);
            header('Location: index.php');
            exit();
        }
        case 'login':
        {
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';

            login($email, $password);
            header('Location: index.php');
            exit();
        }

        case 'filtro_coches':
        {
            $filters = $_POST['filters'];
            $cars = filterCars($filters);

            // Asegúrate de procesar la respuesta de los coches con HTML adecuado aquí antes de enviarla de vuelta al cliente
            ob_start();
            $counter = 0;
            foreach ($cars as $car) {
                if ($counter != 0 && $counter%4 == 0) {
                    echo '</div><div class="row">';
                }

                echo '<div class="col-sm-3">
                <div class="panel panel-primary">
                    <div class="panel-heading">'. $car["Marca"] .' '. $car["Modelo"] .'</div>
                    <div class="panel-body"><img src="https://placehold.it/150x80?text='. $car["Matricula"] .'" class="img-responsive" style="width:100%" alt="Image"></div>
                    <div class="panel-footer">'. $car["Descripcion"] .'</div>
                </div>
              </div>';

                $counter++;
            }
            if ($counter != 0) {
                echo '</div>';
            }

            $response = ob_get_clean();

            echo $response;
            break;
        }
        case 'logout':
        {
            session_destroy();
            break;
        }
    }
}