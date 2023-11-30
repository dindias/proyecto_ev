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
            // Obtén los datos del formulario
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $email = $_POST['email'];
            $nacimiento = $_POST['nacimiento'];
            $direccion = $_POST['direccion'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            // Llama a la función registrarUsuario() y obtén la respuesta
            $response = registrarUsuario($nombre, $apellido, $email, $nacimiento, $direccion, $password, $confirm_password);

            // Envia la respuesta al JavaScript en formato JSON
            echo json_encode($response);
            exit();
        }
        case 'login':
        {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $response = login($email, $password);

            echo json_encode($response);
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
            if (!empty($_POST['descripcion'])) {
                $valuesToUpdate['descripcion'] = $_POST['descripcion'];
            }
            print_r($valuesToUpdate);
            if (!empty($_FILES['imagen']['name'])) {
                $uploadDir = './img/'; // Cambia esto con la ruta deseada
                $uploadFile = $uploadDir . basename($_FILES['imagen']['name']);

                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadFile)) {
                    // Imagen cargada exitosamente, guarda la ruta en la base de datos o realiza otras acciones necesarias
                    $valuesToUpdate['imagen'] = $uploadFile;
                } else {
                    echo "Error al cargar la imagen.";
                    exit;
                }
            }
            $user = updateUser($userID, $valuesToUpdate);

            //header("Refresh:0");
            break;
        }
            case 'añadir_coche':
            {
                $userID = $_SESSION['user_id'];
                $marca = $_POST['Marca'];
                $modelo = $_POST['Modelo'];
                $ano = $_POST['Ano'];
                $matricula = $_POST['Matricula'];
                $potencia = $_POST['Potencia'];
                $autonomia = $_POST['Autonomia'];
                $kilometraje = $_POST['Kilometraje'];
                $motorizacion = $_POST['Motorizacion'];
                $contaminacion = $_POST['Contaminacion'];
                $precio = $_POST['Precio'];
                $tipo = $_POST['Tipo'];
                $ubicacion = $_POST['Ubicacion'];
                $descripcion = $_POST['Descripcion'];
                $exterior = $_POST['Exterior'];
                $interior = $_POST['Interior'];
                $seguridad = $_POST['Seguridad'];
                $tecnologia = $_POST['Tecnologia'];

                $carID = insertCar($userID, $marca, $modelo, $ano, $matricula, $potencia, $autonomia, $kilometraje, $motorizacion, $contaminacion, $precio, $tipo, $ubicacion, $descripcion, $exterior, $interior, $seguridad, $tecnologia);

                if ($carID) {
                    if(isset($_FILES["imagenes"])) {
                        $uploadedImages = insertImages($userID, $carID, $_FILES["imagenes"]);

                        if (!$uploadedImages) {
                            echo "Error al guardar las imágenes.";
                        }
                    }
                } else {
                    echo "Error al guardar los datos del coche.";
                }
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
        case 'recoger_coche':
        {
            $carId = $_POST['carID'];
            $car = getCar($carId);

            echo json_encode($car);
            exit;
        }
        case 'paginate_cars':
        {
            $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;

            // Recoger los filtros desde $_POST y limpiarlos
            $filters = [];
            foreach (['marca', 'modelo', 'ano', 'potencia', 'autonomia', 'kilometraje', 'motorizacion', 'ubicacion', 'precio', 'tipo'] as $key) {
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
                if (isset($_FILES["imagenes"])) {
                    $uploadedImages = insertImages($userID, $valuesToUpdate['carID'], $_FILES["imagenes"]);

                    if (!$uploadedImages) {
                        echo "Error al guardar las imágenes.";
                    }
                }
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
            if (!empty($_POST['Potencia'])) {
                $valuesToUpdate['Potencia'] = $_POST['Potencia'];
            }
            if (!empty($_POST['Autonomia'])) {
                $valuesToUpdate['Autonomia'] = $_POST['Autonomia'];
            }
            if (!empty($_POST['Kilometraje'])) {
                $valuesToUpdate['Kilometraje'] = $_POST['Kilometraje'];
            }
            if (!empty($_POST['Motorizacion'])) {
                $valuesToUpdate['Motorizacion'] = $_POST['Motorizacion'];
            }
            if (!empty($_POST['Contaminacion'])) {
                $valuesToUpdate['Contaminacion'] = $_POST['Contaminacion'];
            }
            if (!empty($_POST['Precio'])) {
                $valuesToUpdate['Precio'] = $_POST['Precio'];
            }
            if (!empty($_POST['Tipo'])) {
                $valuesToUpdate['Tipo'] = $_POST['Tipo'];
            }
            if (!empty($_POST['Ubicacion'])) {
                $valuesToUpdate['Ubicacion'] = $_POST['Ubicacion'];
            }
            if (!empty($_POST['Descripcion'])) {
                $valuesToUpdate['Descripcion'] = $_POST['Descripcion'];
            }
            if (!empty($_POST['Exterior'])) {
                $valuesToUpdate['Exterior'] = $_POST['Exterior'];
            }
            if (!empty($_POST['Interior'])) {
                $valuesToUpdate['Interior'] = $_POST['Interior'];
            }
            if (!empty($_POST['Seguridad'])) {
                $valuesToUpdate['Seguridad'] = $_POST['Seguridad'];
            }
            if (!empty($_POST['Tecnologia'])) {
                $valuesToUpdate['Tecnologia'] = $_POST['Tecnologia'];
            }

            updateCar($userID, $valuesToUpdate);
            header('Location: control_panel.php');
            break;
        }

        case 'reservar_coche':
        {
            if (isset($_POST['carID']) && isset($_SESSION['user_id']) && isset($_POST['startDate']) && isset($_POST['endDate']) && isset($_POST['precioTotal'])) {
                $carId = $_POST['carID'];
                $userID = $_SESSION['user_id'];
                $startDate = $_POST['startDate'];
                $endDate = $_POST['endDate'];
                $precioTotal = $_POST['precioTotal'];
                $observaciones = $_POST['observaciones'] ?? '';

                insertarReserva($userID, $carId, $startDate, $endDate, $precioTotal, $observaciones);

                echo json_encode(array('message' => 'Operación exitosa'));
            } else {
                echo json_encode(array('error' => 'Datos faltantes en la solicitud'));
            }
            break;
        }
        case 'eliminar_reserva':
        {
            $reservationID = $_POST['reservationID'];
            $UserID = $_POST['UserID'];

            if ($_SESSION['user_id'] == $UserID) {
                // Los IDs de usuario coinciden, procedemos a eliminar la reserva
                eliminarReserva($reservationID);
            } else {
                // Los IDs de usuario no coinciden, retornamos un error
                echo json_encode(['success' => false, 'message' => 'No tienes permiso para eliminar esta reserva']);
            }
            break;
        }
        case 'agregarFavorito':
        {
            $car = $_POST['carID'];
            $userID = $_SESSION['user_id'];

            insertarFavorito($car, $userID);
            break;
        }
        case 'eliminarFavorito':
        {
            $car = $_POST['carID'];
            $userID = $_SESSION['user_id'];

            eliminarFavorito($car, $userID);
            break;
        }
        case 'esFavorito':
        {
            $car = $_POST['carID'];
            $userID = $_SESSION['user_id'];

            checkFavorito($car, $userID);
            break;
        }
        case 'checkFecha':
        {
            $userID = $_SESSION['user_id'];
            $carID = $_POST['carID'];
            $fechas = getReservedDates($carID);
            break;
        }
        case 'checkNotificacion':
        {
            $userID = $_POST['userID'];
            $notifications = getUnreadNotifications($userID);
            echo json_encode($notifications);
            exit;
        }
        case 'markNotification':
        {
            $notificationID = $_POST['notificationID'];
            $notifications = markNotificationAsRead($notificationID);
            echo json_encode($notifications);
            exit;
        }
        case 'getNotificaciones':
        {
            $userID = $_POST['userID'];
            $notifications = getNotifications($userID);
            echo json_encode($notifications);
            exit;
        }
        case 'recoger_perfil':
        {
            $userID = $_POST['userID'];
            $user = getYourData($userID);
            echo json_encode($user);
            exit;
        }
        case 'registroUsuarios':
        {
            $data = getRegistrationHistory();
            echo json_encode($data);
            exit;
        }
        case 'contaminacionCoches':
        {
            $data = getContaminationData();
            echo json_encode($data);
            exit;
        }
        case 'tiposCoche':
        {
            $data = getCarsByType();
            echo json_encode($data);
            exit;
        }
        case 'evolucionReservas':
        {
            $data = getReservationEvolution();
            echo json_encode($data);
            exit;
        }
        case 'tablaCoches':
        {
            $data = getTablaCoches();
            echo json_encode($data);
            exit;
        }
        case 'tablaFavoritos':
        {
            $data = getTablaFavoritos();
            echo json_encode($data);
            exit;
        }
        case 'tablaReservas':
        {
            $data = getTablaReservas();
            echo json_encode($data);
            exit;
        }
        case 'tablaUsuarios':
        {
            $data = getTablaUsuarios();
            echo json_encode($data);
            exit;
        }
        case 'modificarCoches':
        {
            // Obtenemos los datos del cuerpo de la solicitud
            $requestData = json_decode($_POST['modifiedData']);

            // Llamamos a la función para actualizar usuarios
            $data = updateCoches($requestData);

            // Enviamos la respuesta como JSON
            //echo json_encode($data);
            exit;
        }
        case 'modificarFavoritos':
        {
            // Obtenemos los datos del cuerpo de la solicitud
            $requestData = json_decode($_POST['modifiedData']);

            // Llamamos a la función para actualizar usuarios
            $data = updateFavoritos($requestData);

            // Enviamos la respuesta como JSON
            echo json_encode($data);
            exit;
        }
        case 'modificarReservas':
        {
            // Obtenemos los datos del cuerpo de la solicitud
            $requestData = json_decode($_POST['modifiedData']);

            // Llamamos a la función para actualizar usuarios
            $data = updateReservas($requestData);

            // Enviamos la respuesta como JSON
            echo json_encode($data);
            exit;
        }
        case 'modificarUsuarios':
        {
            // Obtenemos los datos del cuerpo de la solicitud
            $requestData = json_decode($_POST['modifiedData']);

            // Llamamos a la función para actualizar usuarios
            $data = updateUsuarios($requestData);

            // Enviamos la respuesta como JSON
            echo json_encode($data);
            exit;
        }
        case 'eliminarFila':
        {
            $tabla = $_POST['tabla'];
            $campoID = $_POST['campoID'];
            $id = $_POST['rowId'];

            $data = eliminarFila($tabla, $campoID, $id);

            echo json_encode($data);
            exit;
        }
    }
}