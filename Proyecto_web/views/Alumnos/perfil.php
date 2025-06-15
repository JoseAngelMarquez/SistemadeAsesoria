<?php
session_start();
require_once(__DIR__ . "/../../controller/PerfilAlumnoController.php");

// Verificar que el usuario haya iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header('Location: /Proyecto_web/views/login_Alumno.php');
    exit;
}

$userId = $_SESSION['user_id'];
$controller = new AlumnoController($conexion);

// Recuperar los datos del perfil del alumno
$resultado = $controller->perfil($userId);
$alumno = $resultado['alumno'];
$message = $resultado['message'];

// Procesar el formulario de actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = [
        'nombre' => $_POST['nombre'],
        'apellido_pa' => $_POST['apellido_pa'],
        'apellido_ma' => $_POST['apellido_ma'],
        'grupo' => $_POST['grupo'],
        'semestre' => $_POST['semestre'],
        'email' => $_POST['email'],
        'telefono' => $_POST['telefono'],
        'direccion' => $_POST['direccion'],
        'fecha_nacimiento' => $_POST['fecha_nacimiento'],
        'licenciatura' => $_POST['licenciatura']
    ];

    $message = $controller->actualizarPerfil($userId, $datos);
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/Proyecto_web/assets/cssalumno/perfil.css">
    <link rel="stylesheet" href="/Proyecto_web/assets/css/esqueleto.css">
    <title>Perfil</title>
</head>

<body>
    <div class="container">
        <!-- Menú lateral izquierdo -->
        <nav class="sidebar">
            <ul>
                <li><a href="inicio.php"><i class="fas fa-home"></i> Inicio</a></li>
                <li><a href="Solicitar_asesoria.php"><i class="fas fa-chart-line"></i> Solicitar asesorías</a></li>
                <li><a href="misasesorias.php"><i class="fas fa-users"></i> Mis asesorías</a></li>
                <li><a href="encuesta.php"><i class="fas fa-cogs"></i> Encuesta</a></li>
                <li><a href="perfil.php"><i class="fas fa-question-circle"></i> Perfil</a></li>
            </ul>
            <div class="logout">
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Salir</a>
            </div>
        </nav>

        <!-- Contenido principal -->
        <div class="main-content">
            <div class="top-bar">
                <div class="logo-section">
                <img class="unsis" src="/Proyecto_web/assets/img/unsis.png" alt="">
                <span class="software-name">UNSIS BOOST</span>
                </div>
                <div class="user-section">
                    <i class="fas fa-user-circle avatar"></i>
                    <button class="user-button">Perfil</button>
                </div>
            </div>

            <!-- Resto del contenido -->
            <div class="content">
                <h1>Perfil del Alumno</h1>
                <?php if (!empty($message)) : ?>
                    <p><?php echo $message; ?></p>
                <?php endif; ?>
                <form method="POST">
                    <div class="profile-container">
                        <div class="profile-info">
                            <div class="profile-photo">
                                <img src="/Proyecto_web/assets/img/perfil.png" alt="Foto de Perfil" class="avatar-img">
                            </div>
                            <div class="student-details">
                                <label for="matricula">Matrícula:</label>
                                <input type="text" id="matricula" name="matricula" value="<?php echo htmlspecialchars($alumno['matricula'] ?? ''); ?>" disabled>

                                <label for="nombre">Nombre:</label>
                                <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($alumno['nombre'] ?? ''); ?>" required>

                                <label for="apellido_pa">Apellido Paterno:</label>
                                <input type="text" id="apellido_pa" name="apellido_pa" value="<?php echo htmlspecialchars($alumno['apellido_pa'] ?? ''); ?>" required>

                                <label for="apellido_ma">Apellido Materno:</label>
                                <input type="text" id="apellido_ma" name="apellido_ma" value="<?php echo htmlspecialchars($alumno['apellido_ma'] ?? ''); ?>" required>

                                <label for="grupo">Grupo:</label>
                                <input type="text" id="grupo" name="grupo" value="<?php echo htmlspecialchars($alumno['grupo'] ?? ''); ?>" required>

                                <label for="semestre">Semestre:</label>
                                <input type="number" id="semestre" name="semestre" value="<?php echo htmlspecialchars($alumno['semestre'] ?? ''); ?>" required>
                            </div>
                        </div>

                        <div class="profile-fields">
                            <label for="email">Correo Electrónico:</label>
                            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($alumno['email'] ?? ''); ?>" required>

                            <label for="telefono">Teléfono:</label>
                            <input type="tel" id="telefono" name="telefono" value="<?php echo htmlspecialchars($alumno['telefono'] ?? ''); ?>" required>

                            <label for="direccion">Dirección:</label>
                            <input type="text" id="direccion" name="direccion" value="<?php echo htmlspecialchars($alumno['direccion'] ?? ''); ?>" required>

                            <label for="fecha-nacimiento">Fecha de Nacimiento:</label>
                            <input type="date" id="fecha-nacimiento" name="fecha-nacimiento" value="<?php echo htmlspecialchars($alumno['fecha_nacimiento'] ?? ''); ?>" required>

                            <label for="licenciatura">Licenciatura:</label>
                            <input type="text" id="licenciatura" name="licenciatura" value="<?php echo htmlspecialchars($alumno['licenciatura'] ?? ''); ?>" required>
                        </div>
                    </div>

                    <div class="button-container">
                        <button type="submit" class="button1">Actualizar Perfil</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
