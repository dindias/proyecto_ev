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

function registrarUsuario($nombre, $apellido, $email, $nacimiento, $direccion, $password)
{
    // Llamada a la función connectDB() para obtener la conexión
    $conn = connectDB();

    if ($conn != null) {
        try {
            $sql = "INSERT INTO usuarios (Nombre, Apellido, Email, Nacimiento, Direccion, password) 
                        VALUES (:nombre, :apellido, :email, :nacimiento, :direccion, :password)";

            $stmt = $conn->prepare($sql);

            // Hash de la contraseña
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':apellido', $apellido, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':nacimiento', $nacimiento, PDO::PARAM_STR);
            $stmt->bindParam(':direccion', $direccion, PDO::PARAM_STR);
            $stmt->bindParam(':password', $passwordHash, PDO::PARAM_STR);

            $stmt->execute();

            echo 'Usuario registrado con éxito';

        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }

    } else {
        echo 'No se pudo conectar a la base de datos.';
    }
}

function login($email, $password) {
    $conn = connectDB();
    $stmt = $conn->prepare('SELECT * FROM usuarios WHERE Email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['user_id'] = $user['UserID'];
        $_SESSION['nombre'] = $user['Nombre'];
    } else {
        echo 'Correo electrónico o contraseña incorrecto.';
    }
}

function getReservas($userID)
{
    $conn = connectDB();

    try {
        // Consultar las reservas y sus datos de coche para el usuario
        $stmt = $conn->prepare("SELECT r.*, c.Marca, c.Modelo, c.Ano, c.Matricula, c.Kilometraje, c.Descripcion, c.Precio, c.imagenes
                                FROM reservas r
                                JOIN coches c ON c.CarID = r.CarID
                                WHERE r.UserID = :userID");
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->execute();

        // Set the resulting array to associative
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

        // Retornar las reservas con los datos del coche
        return $stmt->fetchAll();
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

function insertCar($userID, $marca, $modelo, $ano, $matricula, $kilometraje, $descripcion, $precio, $tipo) {
    try {
        $conn = connectDB();

        $query = 'INSERT INTO `coches` (`UserID`, `Marca`, `Modelo`, `Ano`, `Matricula`, `Kilometraje`, `Descripcion`, `Precio`, `Tipo`) 
                  VALUES (:userID, :marca, :modelo, :ano, :matricula, :kilometraje, :descripcion, :precio, :tipo)';
        $params = [
            ':userID' => $userID,
            ':marca' => $marca,
            ':modelo' => $modelo,
            ':ano' => $ano,
            ':matricula' => $matricula,
            ':kilometraje' => $kilometraje,
            ':descripcion' => $descripcion,
            ':precio' => $precio,
            ':tipo' => $tipo
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
    $sql = "DELETE FROM coches WHERE CarID = :carId";

    try {
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':carId', $carId);
        $stmt->execute();

        echo 'Coche eliminado con éxito';
    } catch(PDOException $e) {
        echo 'Error al eliminar coche: ' . $e->getMessage();
    }
}

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

function insertarReserva($userID, $carID, $fechaInicio, $fechaFin, $observaciones)
{
    try {
        $conn = connectDB();

        if ($conn !== null) {
            $sql = "INSERT INTO reservas (UserID, CarID, FechaInicio, FechaFin, Observaciones) VALUES (:userID, :carID, :fechaInicio, :fechaFin, :observaciones)";
            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
            $stmt->bindParam(':carID', $carID, PDO::PARAM_INT);
            $stmt->bindParam(':fechaInicio', $fechaInicio, PDO::PARAM_STR);
            $stmt->bindParam(':fechaFin', $fechaFin, PDO::PARAM_STR);
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

