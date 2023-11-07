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

function getCars()
{
    $conn = connectDB();

    try {
        // Consultar todos los coches
        $stmt = $conn->prepare("SELECT * FROM coches");
        $stmt->execute();

        // Set the resulting array to associative
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

        // Retornar todos los coches
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

    foreach ($filters as $key => $value) {
        if ($value !== null && $value !== '') {
            $cleanKey = preg_replace('/[^a-zA-Z0-9_ñÑ]/u', '', $key);
            $whereParts[] = "$cleanKey = :$cleanKey";
            $params[":$cleanKey"] = $value;
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

    foreach ($filters as $key => $value) {
        if ($value !== null && $value !== '') {
            $cleanKey = preg_replace('/[^a-zA-Z0-9_ñÑ]/u', '', $key);
            $whereParts[] = "$cleanKey = :$cleanKey";
            $params[":$cleanKey"] = $value;
        }
    }

    $whereClause = ''; // Iniciar cláusula WHERE vacía
    if (!empty($whereParts)) {
        $whereClause = ' WHERE ' . implode(' AND ', $whereParts);
    }

    try {
        $sql = "SELECT * FROM coches {$whereClause} LIMIT :limit OFFSET :offset";
        $stmt = $conn->prepare($sql);

        // Vincular parámetros de filtro
        foreach ($params as $param => $value) {
            $stmt->bindValue($param, $value);
        }

        // Vincular parámetros de paginación
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

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

// La función updateUser podría ser algo así:
function updateUser($userID, $valuesToUpdate) {
    $conn = connectDB();

    $sql = "UPDATE usuarios SET ";
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

    // Si la actualización fue exitosa, actualiza la variable de sesión del nombre
    if ($result && array_key_exists('nombre', $valuesToUpdate)) {
        $_SESSION['nombre'] = $valuesToUpdate['nombre'];
    }

    return $result;
}

function getUserCars($userID) {
    $conn = connectDB();
    $query = 'SELECT * FROM `coches` WHERE `UserID` = :userID';
    $statement = $conn->prepare($query);
    $statement->execute([':userID' => $userID]);

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function insertCar($userID, $marca, $modelo, $ano, $matricula, $kilometraje, $descripcion, $precio, $imagen) {
    try {
        $conn = connectDB();

        $query = 'INSERT INTO `coches` (`UserID`, `Marca`, `Modelo`, `Ano`, `Matricula`, `Kilometraje`, `Descripcion`, `Precio`, `imagenes`) 
                  VALUES (:userID, :marca, :modelo, :ano, :matricula, :kilometraje, :descripcion, :precio, :imagen)';
        $params = [
            ':userID' => $userID,
            ':marca' => $marca,
            ':modelo' => $modelo,
            ':ano' => $ano,
            ':matricula' => $matricula,
            ':kilometraje' => $kilometraje,
            ':descripcion' => $descripcion,
            ':precio' => $precio,
            ':imagen' => $imagen
        ];

        $statement = $conn->prepare($query);

        if($statement->execute($params)) {
            return true;
        } else {
            var_dump($statement->errorInfo());
            return false;
        }

    } catch (PDOException $error) {
        echo "PDO Error: " . $error->getMessage();
        exit();
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



