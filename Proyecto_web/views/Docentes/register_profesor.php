<?php
// Conexión a la base de datos
require_once __DIR__ . '/../../config/db_config.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibe los datos del formulario
    $matricula = $_POST["matricula"];
    $username = $_POST['user'];
    $password = $_POST['password'];
    $nombre = $_POST['nombre'];
    $apellido_pa = $_POST['apellido_pa'];
    $apellido_ma = $_POST['apellido_ma'];
    $carrera = $_POST['carrera'];

    // Validación para asegurarse que el usuario no exista ya
    $stmt = $conexion->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $message = "El nombre de usuario ya está en uso.";
    } else {
        // Hashear la contraseña
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Iniciar transacción
        $conexion->begin_transaction();

        try {
            // Insertar el usuario
            $stmt = $conexion->prepare("INSERT INTO users (username, password, role_id) VALUES (?, ?, ?)");
            $roleId = 2; // Maestro
            $stmt->bind_param("ssi", $username, $hashedPassword, $roleId);
            $stmt->execute();

            // Obtener el ID del usuario recién insertado
            $userId = $conexion->insert_id;

            // Insertar el profesor
            $stmt = $conexion->prepare("INSERT INTO maestros (matricula, nombre, apellido_pa, apellido_ma, carrera, user_id) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssi", $matricula, $nombre, $apellido_pa, $apellido_ma, $carrera, $userId);
            $stmt->execute();

            // Confirmar la transacción
            $conexion->commit();
            $message = "Registro exitoso. Puedes iniciar sesión ahora.";
        } catch (Exception $e) {
            // Si ocurre un error, revertir la transacción
            $conexion->rollback();
            $message = "Error al registrar el profesor. Intenta nuevamente. Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Profesor</title>
    <link rel="stylesheet" href="/Proyecto_web/assets/cssregistros/registerprofesor.css">
</head>
<body>
    <form action="register_profesor.php" method="POST">
    <div class="login-box">
    <h2>Registrar Profesor</h2>
        <div>
            <label for="matricula">Matrícula:</label>
            <input type="text" name="matricula" required> 
        </div>
        <div>
            <label for="user">Usuario:</label>
            <input type="text" name="user" required>
        </div>
        <div>
            <label for="password">Contraseña:</label>
            <input type="password" name="password" required>
        </div>
        <div>
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" required>
        </div>
        <div>
            <label for="apellido_pa">Apellido Paterno:</label>
            <input type="text" name="apellido_pa" required>
        </div>
        <div>
            <label for="apellido_ma">Apellido Materno:</label>
            <input type="text" name="apellido_ma" required>
        </div>
        <div>
            <label for="carrera">Carrera:</label>
            <input type="text" name="carrera" required>
        </div>
       
        <button type="submit"  class="button1">Registrar</button>

        <?php if ($message): ?>
            <div><?php echo $message; ?></div>
        <?php endif; ?>
        <button type="button" class="button2">Loguearse</button>
    </form>
    </div>  
</body>
</html>
