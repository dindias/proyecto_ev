<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
function connectDB()
{
    $servername = "localhost";
    $DB = "proyecto_ev";
    $username = "root";
    $password_bd = "";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$DB", $username, $password_bd);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;

    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        return null;
    }
}

function registrarUsuario($nombre, $apellido, $email, $nacimiento, $direccion, $password, $confirm_password)
{
    // Comprobaciones
    if (empty($nombre) || empty($apellido) || empty($email) || empty($nacimiento) || empty($direccion) || empty($password) || empty($confirm_password)) {
        return ['status' => 'error', 'message' => 'Todos los campos son obligatorios.'];
    }

    if ($password !== $confirm_password) {
        return ['status' => 'error', 'message' => 'Las contraseñas no coinciden.'];
    }

    // Llamada a la función connectDB() para obtener la conexión
    $conn = connectDB();

    if ($conn != null) {
        try {
            // Verificar si el correo electrónico ya existe
            $checkEmailQuery = "SELECT COUNT(*) as count FROM usuarios WHERE Email = :email";
            $checkEmailStmt = $conn->prepare($checkEmailQuery);
            $checkEmailStmt->bindParam(':email', $email, PDO::PARAM_STR);
            $checkEmailStmt->execute();
            $emailCount = $checkEmailStmt->fetch(PDO::FETCH_ASSOC)['count'];

            if ($emailCount > 0) {
                return ['status' => 'error', 'message' => 'El correo electrónico ya está registrado.'];
            }

            // Consulta SQL para insertar en la base de datos
            $sql = "INSERT INTO usuarios (Nombre, Apellido, Email, Nacimiento, Direccion, password) 
                    VALUES (:nombre, :apellido, :email, :nacimiento, :direccion, :password)";

            $stmt = $conn->prepare($sql);

            // Hash de la contraseña
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            // Bind de los parámetros
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':apellido', $apellido, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':nacimiento', $nacimiento, PDO::PARAM_STR);
            $stmt->bindParam(':direccion', $direccion, PDO::PARAM_STR);
            $stmt->bindParam(':password', $passwordHash, PDO::PARAM_STR);

            // Ejecución de la consulta
            $stmt->execute();

            // Respuesta de éxito
            return ['status' => 'success', 'message' => 'Usuario registrado con éxito.'];

        } catch (PDOException $e) {
            // Respuesta de error en caso de excepción
            return ['status' => 'error', 'message' => 'Error: ' . $e->getMessage()];
        }

    } else {
        // Respuesta de error si no se pudo conectar a la base de datos
        return ['status' => 'error', 'message' => 'No se pudo conectar a la base de datos.'];
    }
}

function login($email, $password) {
    $conn = connectDB();
    $stmt = $conn->prepare('SELECT * FROM usuarios WHERE Email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['UserID'];
        $_SESSION['nombre'] = $user['Nombre'];

        // Devuelve un JSON con éxito
        return ['status' => 'success', 'message' => 'Inicio de sesión exitoso'];
    } else {
        // Devuelve un JSON con error
        return ['status' => 'error', 'message' => 'Correo electrónico o contraseña incorrecto.'];
    }
}


function getReservas($userID)
{
    $conn = connectDB();

    try {
        // Consultar las reservas y sus datos de coche para el usuario, incluyendo el join con la tabla de imágenes
        $stmt = $conn->prepare("SELECT r.*, c.Marca, c.Modelo, c.Ano, c.Matricula, c.Potencia , c.Autonomia, c.Descripcion, c.Precio, c.Tipo, i.Imagen
                                FROM reservas r
                                JOIN coches c ON c.CarID = r.CarID
                                LEFT JOIN imagenes i ON i.CarID = c.CarID AND i.UserID = r.UserID
                                WHERE r.UserID = :userID");
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->execute();

        // Establecer el modo de resultado en modo asociativo
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

        // Organizar los resultados por ReservationID para manejar múltiples imágenes por coche
        $reservas = [];
        while ($row = $stmt->fetch()) {
            $reservaID = $row['ReservationID'];
            if (!isset($reservas[$reservaID])) {
                $reservas[$reservaID] = $row;
                $reservas[$reservaID]['Imagenes'] = [];
            }

            // Agregar la imagen a la reserva si está presente
            if (!empty($row['Imagen'])) {
                $reservas[$reservaID]['Imagenes'][] = $row['Imagen'];
            }
        }

        // Retornar las reservas con los datos del coche e imágenes
        return array_values($reservas); // Reindexar el array antes de devolverlo
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return [];
    }
}


function getTotalCars($filters = []) {
    $conn = connectDB();
    $whereParts = [];
    $params = [];

    foreach ($filters as $key => $values) {
        // Asegurarse de que $values sea un array
        $values = (array)$values;
        if(!empty($values)){
            $cleanKey = preg_replace('/[^a-zA-Z0-9_ñÑ]/u', '', $key);
            $placeholders = [];
            foreach($values as $ix => $value){
                $placeholder = ":{$cleanKey}_{$ix}";
                $placeholders[] = $placeholder;
                $params[$placeholder] = $value;
            }
            $whereParts[] = "{$cleanKey} IN (" . implode(', ', $placeholders) . ")";
        }
    }

    $whereClause = ''; // Iniciar la cláusula WHERE vacía
    if (!empty($whereParts)) {
        $whereClause = ' WHERE ' . implode(' AND ', $whereParts);
    }

    try {
        // Asegúrese de incluir la cláusula WHERE si hay filtros aplicados
        $sql = "SELECT COUNT(*) FROM coches" . $whereClause;
        $stmt = $conn->prepare($sql);

        // Vincular parámetros de filtro
        foreach ($params as $param => $value) {
            $stmt->bindValue($param, $value);
        }

        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count;

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return 0;
    }
}
function getCarsByPage($page = 1, $limit = 12, $filters = []) {
    $conn = connectDB();
    $offset = ($page - 1) * $limit;
    $whereParts = [];
    $params = [];

    foreach ($filters as $key => $values) {
        // Asegurarse de que $values sea un array
        $values = (array)$values;
        if(!empty($values)){
            $cleanKey = preg_replace('/[^a-zA-Z0-9_ñÑ]/u', '', $key);
            $placeholders = [];
            foreach ($values as $ix => $value) {
                $placeholder = ":{$cleanKey}_{$ix}";
                $placeholders[] = $placeholder;
                $params[$placeholder] = $value;
            }
            $whereParts[] = "{$cleanKey} IN (" . implode(', ', $placeholders) . ")";
        }
    }

    $whereClause = '';
    if (!empty($whereParts)) {
        $whereClause = ' WHERE ' . implode(' AND ', $whereParts);
    }

    try {
        // Incorporamos un LEFT JOIN para obtener las imágenes y utilizamos GROUP BY para agrupar por CarID.
        $sql = "SELECT coches.*, GROUP_CONCAT(imagenes.Imagen SEPARATOR ',') AS Imagenes 
                FROM coches 
                LEFT JOIN imagenes ON coches.CarID = imagenes.CarID 
                {$whereClause} 
                GROUP BY coches.CarID 
                LIMIT :limit OFFSET :offset";

        $stmt = $conn->prepare($sql);

        // Vincular parámetros de filtro
        foreach ($params as $param => $value) {
            $stmt->bindValue($param, $value);
        }

        // Vincular parámetros de paginación
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();
        $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Convertimos la cadena de imágenes en arrays para cada coche
        foreach ($cars as $key => $car) {
            if ($car['Imagenes'] !== null) {
                $cars[$key]['Imagenes'] = explode(',', $car['Imagenes']);
            } else {
                $cars[$key]['Imagenes'] = [];
            }
        }

        return $cars;

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return [];
    }
}

function get_unique_values($column, $table) {
    $conn = connectDB();

    $sql = "SELECT DISTINCT " . $column . " FROM " . $table;
    $stmt = $conn->query($sql);

    $stmt->execute();
    $values = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $values[] = $row[$column];
    }

    return $values;
}

function getUserCars($userID) {
    $conn = connectDB();
    // Modificamos la consulta SQL para hacer un LEFT JOIN con la tabla `imagenes`
    // y usar GROUP_CONCAT para obtener todas las imágenes asociadas con un coche.
    $query = 'SELECT coches.*, GROUP_CONCAT(imagenes.Imagen SEPARATOR ",") AS Imagenes 
              FROM coches
              LEFT JOIN imagenes ON coches.CarID = imagenes.CarID 
              WHERE coches.UserID = :userID 
              GROUP BY coches.CarID';

    $statement = $conn->prepare($query);
    $statement->execute([':userID' => $userID]);

    $cars = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Procesamos el resultado para convertir la cadena Imagenes en un array.
    foreach ($cars as $key => $car) {
        if ($car['Imagenes'] !== null) {
            $cars[$key]['Imagenes'] = explode(',', $car['Imagenes']);
        } else {
            // Si no hay imágenes, asignamos un array vacío.
            $cars[$key]['Imagenes'] = [];
        }
    }

    return $cars;
}

function getCar($CarID) {
    $conn = connectDB();
    // Modificamos la consulta SQL para hacer un LEFT JOIN con la tabla `imagenes`
    // y usar GROUP_CONCAT para obtener todas las imágenes asociadas con un coche.
    $query = 'SELECT coches.*, GROUP_CONCAT(imagenes.Imagen SEPARATOR ",") AS Imagenes 
              FROM coches
              LEFT JOIN imagenes ON coches.CarID = imagenes.CarID 
              WHERE coches.CarID = :CarID 
              GROUP BY coches.CarID';

    $statement = $conn->prepare($query);
    $statement->execute([':CarID' => $CarID]);

    $cars = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Procesamos el resultado para convertir la cadena Imagenes en un array.
    foreach ($cars as $key => $car) {
        if ($car['Imagenes'] !== null) {
            $cars[$key]['Imagenes'] = explode(',', $car['Imagenes']);
        } else {
            // Si no hay imágenes, asignamos un array vacío.
            $cars[$key]['Imagenes'] = [];
        }
    }

    return $cars;
}

function insertCar($userID, $marca, $modelo, $ano, $matricula, $potencia, $autonomia, $kilometraje, $motorizacion, $contaminacion, $precio, $tipo, $ubicacion, $descripcion, $exterior, $interior, $seguridad, $tecnologia) {
    try {
        $conn = connectDB();

        $query = 'INSERT INTO `coches` (`UserID`, `Marca`, `Modelo`, `Ano`, `Matricula` , `Potencia` , `Autonomia`, `Kilometraje`, `Motorizacion`, `Contaminacion`, `Precio`, `Tipo`, `Ubicacion`, `Descripcion`, `Exterior`, `Interior`, `Seguridad`, `Tecnologia`) 
                  VALUES (:userID, :marca, :modelo, :ano, :matricula, :potencia, :autonomia, :kilometraje, :motorizacion, :contaminacion, :precio, :tipo, :ubicacion, :descripcion, :exterior, :interior, :seguridad, :tecnologia)';
        $params = [
            ':userID' => $userID,
            ':marca' => $marca,
            ':modelo' => $modelo,
            ':ano' => $ano,
            ':matricula' => $matricula,
            ':potencia' => $potencia,
            ':autonomia' => $autonomia,
            ':kilometraje' => $kilometraje,
            ':motorizacion' => $motorizacion,
            ':contaminacion' => $contaminacion,
            ':precio' => $precio,
            ':tipo' => $tipo,
            ':ubicacion' => $ubicacion,
            ':descripcion' => $descripcion,
            ':exterior' => $exterior,
            ':interior' => $interior,
            ':seguridad' => $seguridad,
            ':tecnologia' => $tecnologia,
        ];

        $statement = $conn->prepare($query);

        if($statement->execute($params)) {
            return $conn->lastInsertId();
        } else {
            var_dump($statement->errorInfo());
            return false;
        }

    } catch (PDOException $error) {
        echo "PDO Error: " . $error->getMessage();
        exit();
    }
}

function insertImages($userID, $carID, $images) {
    try {
        $conn = connectDB();
        $insertedImages = 0;

        foreach ($images['name'] as $key => $name) {
            $fileName = basename($name);
            $targetDir = "img/";
            $targetFilePath = $targetDir . $fileName;

            if (move_uploaded_file($images["tmp_name"][$key], $targetFilePath)) {
                $query = 'INSERT INTO `imagenes` (`UserID`, `CarID`, `Imagen`) VALUES (:userID, :carID, :imagen)';
                $params = [
                    ':userID' => $userID,
                    ':carID' => $carID,
                    ':imagen' => $targetFilePath
                ];

                $statement = $conn->prepare($query);
                if ($statement->execute($params)) {
                    $insertedImages++;
                }
            }
        }

        return $insertedImages === count($images['name']);

    } catch (PDOException $error) {
        echo "PDO Error: " . $error->getMessage();
        return false;
    }
}

function eliminar_coche($carId) {
    $conn = connectDB();

    try {

        // Elimina las imágenes asociadas al coche
        $sqlDeleteImages = "DELETE FROM imagenes WHERE CarID = :carId";
        $stmtDeleteImages = $conn->prepare($sqlDeleteImages);
        $stmtDeleteImages->bindParam(':carId', $carId);
        $stmtDeleteImages->execute();

        // Elimina el coche de la tabla coches
        $sqlDeleteCar = "DELETE FROM coches WHERE CarID = :carId";
        $stmtDeleteCar = $conn->prepare($sqlDeleteCar);
        $stmtDeleteCar->bindParam(':carId', $carId);
        $stmtDeleteCar->execute();

        // Elimina físicamente los archivos de imágenes
        /*foreach ($images as $image) {
            $path = 'ruta/del/archivo/' . $image; // Reemplaza con la ruta correcta
            unlink($path);
        }*/

    } catch(PDOException $e) {
        echo 'Error al eliminar coche: ' . $e->getMessage();
    }
}

eliminar_coche(80);


function updateUser($userID, $valuesToUpdate) {
    $conn = connectDB();

    $sql = "UPDATE usuarios SET ";
    $result = updateValues($valuesToUpdate, $sql, $conn, $userID);

    // Si la actualización fue exitosa, actualiza la variable de sesión del nombre
    if ($result && array_key_exists('nombre', $valuesToUpdate)) {
        $_SESSION['nombre'] = $valuesToUpdate['nombre'];
    }

    return $result;
}

/**
 * @param $valuesToUpdate
 * @param string $sql
 * @param PDO|null $conn
 * @param $userID
 * @return bool
 */
function updateValues($valuesToUpdate, string $sql, ?PDO $conn, $userID): bool
{
    foreach ($valuesToUpdate as $field => $value) {
        $sql .= "$field=:$field, ";
    }
    $sql = rtrim($sql, ', ') . " WHERE UserID=:userId";
    $stmt = $conn->prepare($sql);
    foreach ($valuesToUpdate as $field => $value) {
        $stmt->bindValue(':' . $field, $value);
    }

    $stmt->bindValue(':userId', $userID, PDO::PARAM_INT);
    $result = $stmt->execute();
    return $result;
}
function updateCar($userID, $valuesToUpdate) {
    $conn = connectDB();

    $sql = "UPDATE coches SET ";
    $result = updateValues($valuesToUpdate, $sql, $conn, $userID);

    return $result;
}

function insertarReserva($userID, $carID, $fechaInicio, $fechaFin, $coste, $observaciones)
{
    try {
        $conn = connectDB();

        if ($conn !== null) {
            $sql = "INSERT INTO reservas (UserID, CarID, FechaInicio, FechaFin, Coste, Observaciones) VALUES (:userID, :carID, :fechaInicio, :fechaFin, :coste, :observaciones)";
            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
            $stmt->bindParam(':carID', $carID, PDO::PARAM_INT);
            $stmt->bindParam(':fechaInicio', $fechaInicio, PDO::PARAM_STR);
            $stmt->bindParam(':fechaFin', $fechaFin, PDO::PARAM_STR);
            $stmt->bindParam(':coste', $coste, PDO::PARAM_STR);
            $stmt->bindParam(':observaciones', $observaciones, PDO::PARAM_STR);

            $stmt->execute();
            return true;
        } else {
            return false; // La conexión a la base de datos falló
        }
    } catch (PDOException $e) {
        echo "Error al insertar reserva: " . $e->getMessage();
        return false; // Ocurrió un error durante la inserción
    }
}

function eliminarReserva($reservationID) {
    $conn = connectDB();

    if ($conn) {
        try {
            // Preparamos la sentencia SQL
            $stmt = $conn->prepare("DELETE FROM reservas WHERE ReservationID = :reservationID");
            $stmt->bindParam(':reservationID', $reservationID, PDO::PARAM_INT);

            // Ejecutamos la sentencia
            $stmt->execute();

            // Respondemos al cliente
            echo json_encode(['success' => true, 'message' => 'Reserva eliminada correctamente']);
        } catch (PDOException $e) {
            // En caso de error
            echo json_encode(['success' => false, 'message' => 'Error al eliminar reserva: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al conectar con la base de datos']);
    }
}

function insertarFavorito($carID, $userID) {
    $conn = connectDB();

    if ($conn) {
        try {
            // Preparamos la sentencia SQL
            $sql = "INSERT INTO favoritos (CarID, UserID) VALUES (:carID, :userID)";
            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
            $stmt->bindParam(':carID', $carID, PDO::PARAM_INT);

            // Ejecutamos la sentencia
            $stmt->execute();

            // Respondemos al cliente
            echo json_encode(['success' => true, 'message' => 'Insertado en favoritos']);
        } catch (PDOException $e) {
            // En caso de error
            echo json_encode(['success' => false, 'message' => 'Error al insertar favorito: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al conectar con la base de datos']);
    }
}

function eliminarFavorito($carID, $userID): void
{
    $conn = connectDB();

    if ($conn) {
        try {
            // Preparamos la sentencia SQL
            $sql = "DELETE FROM favoritos WHERE CarID = :carID AND UserID = :userID";
            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
            $stmt->bindParam(':carID', $carID, PDO::PARAM_INT);

            // Ejecutamos la sentencia
            $stmt->execute();

            // Respondemos al cliente
            echo json_encode(['success' => true, 'message' => 'Eliminado de favoritos']);
        } catch (PDOException $e) {
            // En caso de error
            echo json_encode(['success' => false, 'message' => 'Error al eliminar favorito: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al conectar con la base de datos']);
    }
}

function checkFavorito($carID, $userID) {
    $conn = connectDB();

    if ($conn) {
        try {
            // Preparamos la sentencia SQL
            $sql = "SELECT * FROM favoritos WHERE CarID = :carID AND UserID = :userID";
            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
            $stmt->bindParam(':carID', $carID, PDO::PARAM_INT);

            // Ejecutamos la sentencia
            $stmt->execute();

            // Contamos el número de filas devueltas
            $rowCount = $stmt->rowCount();

            // Devolvemos la respuesta al cliente
            echo json_encode(['success' => true, 'isFavorito' => $rowCount > 0]);
        } catch (PDOException $e) {
            // En caso de error, devolvemos un mensaje al cliente
            echo json_encode(['success' => false, 'message' => 'Error al verificar favorito: ' . $e->getMessage()]);
        }
    } else {
        // En caso de error al conectar con la base de datos
        echo json_encode(['success' => false, 'message' => 'Error al conectar con la base de datos']);
    }
}

function getUserFavoriteCars($userID) {
    $conn = connectDB();
    // Modificamos la consulta SQL para hacer un LEFT JOIN con las tablas `favoritos`, `coches`, y `imagenes`
    // y usar GROUP_CONCAT para obtener todas las imágenes asociadas con un coche.
    $query = 'SELECT coches.*, GROUP_CONCAT(imagenes.Imagen SEPARATOR ",") AS Imagenes 
              FROM favoritos
              JOIN coches ON favoritos.CarID = coches.CarID
              LEFT JOIN imagenes ON coches.CarID = imagenes.CarID 
              WHERE favoritos.UserID = :userID 
              GROUP BY coches.CarID';

    $statement = $conn->prepare($query);
    $statement->execute([':userID' => $userID]);

    $cars = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Procesamos el resultado para convertir la cadena Imagenes en un array.
    foreach ($cars as $key => $car) {
        if ($car['Imagenes'] !== null) {
            $cars[$key]['Imagenes'] = explode(',', $car['Imagenes']);
        } else {
            // Si no hay imágenes, asignamos un array vacío.
            $cars[$key]['Imagenes'] = [];
        }
    }

    return $cars;
}

function getReservedDates()
{
    // Asegurate de que este header sea lo primero antes de cualquier salida.
    header('Content-Type: application/json');

    $conn = connectDB();

    if ($conn === null) {
        // Devuelve un mensaje de error como JSON y detén la ejecución.
        echo json_encode(['error' => 'No se pudo conectar a la base de datos.']);
        exit; // Importante para detener la ejecución del script
    }

    try {
        $stmt = $conn->prepare("SELECT FechaInicio, FechaFin FROM reservas");
        $stmt->execute();

        // fetchAll te dará un array, incluso si está vacío.
        $reservedDates = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Devuelve el array como un JSON.
        echo json_encode($reservedDates);
        exit; // Detiene la ejecución del script después de imprimir el JSON.
    } catch (PDOException $e) {
        // Si hay un error en la consulta, devuelve ese error como JSON.
        echo json_encode(['error' => $e->getMessage()]);
        exit; // Importante para detener la ejecución del script.
    }
}