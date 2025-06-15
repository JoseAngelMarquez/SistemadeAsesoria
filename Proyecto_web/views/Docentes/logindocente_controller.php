<?php
//Llamada al controlador del login
require_once __DIR__ . '/../../controller/LoginDocenteController.php';

$loginController = new LoginController();
$message = $loginController->login();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Proyecto_web/assets/cssdocente/iniciodocente.css">
    <link rel="stylesheet" href="/Proyecto_web/assets/css/login.css">
    <title>Login Docente</title>
</head>
<body>
    <div class="login-box">
        <form action="logindocente_controller.php" method="POST">
            <h2>Login Docente</h2>
            <div class="avatar-container">
                <img src="/Proyecto_web/assets/img/avatarh.png" alt="" class="avatar-male">
                <img src="/Proyecto_web/assets/img/avatarm.png" alt="" class="avatar-female">
            </div>
            <div>
                <label for="user">Usuario:</label>
                <input type="text" name="user" required>
            </div>
            <div>
                <label for="password">Contraseña:</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="button1">Iniciar Sesión</button>
            <?php if ($message): ?>
                <div><?php echo $message; ?></div>
            <?php endif; ?>
        </form>
        <a href="register_profesor.php">¿No tienes cuenta? Regístrate aquí como profesor</a>
    </div>
</body>
</html>
