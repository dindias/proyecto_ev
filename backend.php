<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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
        case 'logout':
        {
            session_destroy();
            break;
        }
        case 'modificar_perfil':
        {
            $userID = $_SESSION['user_id'];
            $valuesToUpdate = array();

            if (!empty($_POST['nombre'])) {
                $valuesToUpdate['nombre'] = $_POST['nombre'];
            }
            if (!empty($_POST['apellido'])) {
                $valuesToUpdate['apellido'] = $_POST['apellido'];
            }
            if (!empty($_POST['email'])) {
                $valuesToUpdate['email'] = $_POST['email'];
            }
            if (!empty($_POST['nacimiento'])) {
                $valuesToUpdate['nacimiento'] = $_POST['nacimiento'];
            }
            if (!empty($_POST['numeroCuenta'])) {
                $valuesToUpdate['numeroCuenta'] = $_POST['numeroCuenta'];
            }
            if (!empty($_POST['direccion'])) {
                $valuesToUpdate['direccion'] = $_POST['direccion'];
            }
            if (!empty($_POST['password'])) {
                $valuesToUpdate['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
            }
            updateUser($userID, $valuesToUpdate);
            header('Location: control_panel.php');
            break;
        }
        case 'añadir_coche':
        {
            $userID = $_SESSION['user_id'];
            $marca = $_POST['Marca'];
            $modelo = $_POST['Modelo'];
            $ano = $_POST['Ano'];
            $matricula = $_POST['Matricula'];
            $kilometraje = $_POST['Kilometraje'];
            $descripcion = $_POST['Descripcion'];
            $precio = $_POST['Precio'];
            $imageLocation = "img/generic.jpg"; // Establecer la imagen predeterminada

            if(isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == 0) {
                $targetDir = "img/";
                $fileName = basename($_FILES["imagen"]["name"]);
                $targetFilePath = $targetDir . $fileName;

                if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $targetFilePath)) {
                    $imageLocation = $targetFilePath; // Actualizar con la ubicación de la imagen subida
                }
            } else {
                // Si no se ha subido una imagen, se mantendrá la imagen predeterminada.
                echo "No se ha subido ninguna imagen o hay un error en la carga. Se utilizará la imagen genérica.";
            }

            insertCar($userID, $marca, $modelo, $ano, $matricula, $kilometraje, $descripcion, $precio, $imageLocation);
            header('Location: control_panel.php');
            break;
        }
        case 'eliminar_coche':
        {
            $carId = $_POST['carID'];
            eliminar_coche($carId);
            header('Location: control_panel.php');
            break;
        }
        case 'paginate_cars':
        {
            $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;

            // Recoger los filtros desde $_POST y limpiarlos
            $filters = [];
            foreach (['marca', 'modelo', 'Ano', 'kilometraje', 'precio'] as $key) {
                if (!empty($_POST[$key])) {
                    $filters[$key] = $_POST[$key];
                }
            }

            // Usar las funciones actualizadas con los filtros
            $totalCars = getTotalCars($filters);
            $cars = getCarsByPage($page, 12, $filters);

            header('Content-Type: application/json');
            echo json_encode([
                'totalPages' => ceil($totalCars / 12),
                'cars' => $cars,
            ]);
            break;
        }
        case 'editar_coche':
        {
            $userID = $_SESSION['user_id'];
            $valuesToUpdate = array();

            if (!empty($_POST['carID'])) {
                $valuesToUpdate['carID'] = $_POST['carID'];
            }
            if (!empty($_POST['Marca'])) {
                $valuesToUpdate['Marca'] = $_POST['Marca'];
            }
            if (!empty($_POST['Modelo'])) {
                $valuesToUpdate['Modelo'] = $_POST['Modelo'];
            }
            if (!empty($_POST['Ano'])) {
                $valuesToUpdate['Ano'] = $_POST['Ano'];
            }
            if (!empty($_POST['Matricula'])) {
                $valuesToUpdate['Matricula'] = $_POST['Matricula'];
            }
            if (!empty($_POST['Kilometraje'])) {
                $valuesToUpdate['Kilometraje'] = $_POST['Kilometraje'];
            }
            if (!empty($_POST['Descripcion'])) {
                $valuesToUpdate['Descripcion'] = $_POST['Descripcion'];
            }
            if (!empty($_POST['Precio'])) {
                $valuesToUpdate['Precio'] = $_POST['Precio'];
            }
            if (!empty($_POST['imagen'])) {
                $valuesToUpdate['imagen'] = $_POST['imagen'];
            }
            updateCar($userID, $valuesToUpdate);
            header('Location: control_panel.php');
            break;
        }
        case 'reservar_coche':
        {
            if (isset($_POST['carID']) && isset($_SESSION['user_id']) && isset($_POST['startDate']) && isset($_POST['endDate'])) {
                $carId = $_POST['carID'];
                $userID = $_SESSION['user_id'];
                $startDate = $_POST['startDate'];
                $endDate = $_POST['endDate'];
                $observaciones = '';

                insertarReserva($carId, $userID, $startDate, $endDate, $observaciones);

                echo json_encode(array('message' => 'Operación exitosa'));
            } else {
                echo json_encode(array('error' => 'Datos faltantes en la solicitud'));
            }
            break;
        }
    }
}