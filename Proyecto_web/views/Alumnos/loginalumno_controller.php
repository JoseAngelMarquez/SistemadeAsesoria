<?php
// /views/docentes/login.php

require_once __DIR__ . '/../../controller/LoginAlumnoController.php';

$loginController = new LoginController();
$message = $loginController->login();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Alumno</title>
    <link rel="stylesheet" href="/Proyecto_web/assets/css/login.css" class="href">
</head>
<body">
<div class="login-box">



<form action="loginalumno_controller.php" method="POST">
        <h2>Login Alumno</h2>
        <div class="class avatar-container">
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
        <a href="register_alumno.php">¿No tienes cuenta? Regístrate aquí como alumno</a>

        <button type="submit" class="button1">Iniciar Sesión</button>
        
        <?php if ($message): ?>
            <div><?php echo $message; ?></div>
        <?php endif; ?>
            
    </form>
</div>
  

</body>
</html>
