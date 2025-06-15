<?php
require_once __DIR__ . '/../../controller/RegisterAlumnoController.php';

$controller = new AlumnoController();
$message = $controller->registrar();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Proyecto_web/assets/cssregistros/register.css">
    <title>Registro de Alumno</title>
</head>
<body>
    <div class="login-box">
        <form action="" method="POST">
            <h2>Registrar Alumno</h2>
            <div>
                <label for="matricula">Matrícula:</label>
                <input type="number" name="matricula" required> 
            </div>
            <div>
                <label for="user">Usuario:</label>
                <input type="text" name="user" required> <!-- Cambié el nombre del campo a "user" -->
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
                <label for="grupo">Grupo:</label>
                <input type="text" name="grupo" required>
            </div>
            <div>
                <label for="semestre">Semestre:</label>
                <input type="text" name="semestre" required>
            </div>
            <div>
                <label for="email">Correo:</label> <!-- Cambié el nombre del campo a "email" -->
                <input type="email" name="email" required>
            </div>
            <div>
                <label for="telefono">Teléfono:</label>
                <input type="text" name="telefono">
            </div>
            <div>
                <label for="direccion">Dirección:</label>
                <input type="text" name="direccion">
            </div>
            <div>
                <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                <input type="date" name="fecha_nacimiento" required>
            </div>
            <div>
                <label for="licenciatura">Licenciatura:</label>
                <input type="text" name="licenciatura" required>
            </div>
            <button type="submit" class="button1">Registrar</button>

            <?php if (!empty($message)): ?>
                <div><?php echo $message; ?></div>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
