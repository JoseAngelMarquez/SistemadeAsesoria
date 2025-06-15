<?php
session_start();
require_once '../../config/db_config.php';

if (!isset($_SESSION['user_id'])) {
    // Redirigir al login si no hay sesión activa
    header('Location: /proyecto_web/views/login_Docente.php');
    exit;
}

$userId = $_SESSION['user_id'];
$message = '';

// Recuperar datos del maestro
try {
    $stmt = $conexion->prepare("SELECT * FROM maestros WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $maestro = $result->fetch_assoc();
    } else {
        $message = "No se encontraron datos del maestro.";
    }
} catch (Exception $e) {
    $message = "Error al cargar el perfil: " . $e->getMessage();
}

// Procesar actualización de datos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $apellido_pa = $_POST['apellido_pa'];
    $apellido_ma = $_POST['apellido_ma'];
    $carrera = $_POST['carrera'];

    try {
        $stmt = $conexion->prepare("UPDATE maestros SET nombre = ?, apellido_pa = ?, apellido_ma = ?, carrera = ? WHERE user_id = ?");
        $stmt->bind_param("ssssssssssi", $nombre, $apellido_pa, $apellido_ma, $carrera, $userId);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $message = "Perfil actualizado con éxito.";
        } else {
            $message = "No se realizaron cambios.";
        }
    } catch (Exception $e) {
        $message = "Error al actualizar el perfil: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/Proyecto_web/assets/css/esqueleto.css">
    <link rel="stylesheet" href="/proyecto_web/assets/cssdocente/perfil.css">
    <title>Perfil del Profesor</title>
  
</head>

<body>
    <div class="container">
        <!-- Menú lateral izquierdo -->
        <nav class="sidebar">
            <ul>
                <li><a href="inicio.php"><i class="fas fa-home"></i> Inicio</a></li>
                <li><a href="Solicitar_asesoria.php"><i class="fas fa-chart-line"></i> Asesorías</a></li>
                <li><a href="encuesta.php"><i class="fas fa-cogs"></i> Encuesta</a></li>
                <li><a href="perfil.php"><i class="fas fa-question-circle"></i> Perfil</a></li>
                <li><a href="#"><i class="fas fa-users"></i> Reportes</a></li>
            </ul>
            <div class="logout">
                <a href="#"><i class="fas fa-sign-out-alt"></i> Salir</a>
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
                    <i class="fas fa-user-tie avatar"></i>
                    <button class="user-button">Perfil</button>
                </div>
            </div>

            <!-- Contenido del perfil -->
            <div class="content">
                <h1>Perfil del Profesor</h1>
                <?php if (!empty($message)) : ?>
                    <p><?php echo $message; ?></p>
                <?php endif; ?>
                <form method="POST">

                <div class="profile-container">
                    <div class="profile-info">
                        <div class="profile-photo">
                            <img src="/Proyecto_web/assets/img/avatarh.png" alt="Foto de Perfil" class="avatar-img">
                        </div>
                        <label for="matricula">Matrícula:</label>
                        <input type="text" id="matricula" name="matricula" value="<?php echo htmlspecialchars($maestro['matricula'] ?? ''); ?>" disabled>
                        

                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre"value="<?php echo htmlspecialchars($maestro['nombre'] ?? ''); ?>" disabled>


                        <label for="apellido_pa">Apellido Paterno:</label>
                        <input type="text" id="apellido_pa" name="apellido_pa" value="<?php echo htmlspecialchars($maestro['apellido_pa'] ?? ''); ?>" disabled>

                        <label for="apellido_ma">Apellido Materno:</label>
                        <input type="text" id="apellido_ma" name="apellido_ma" value="<?php echo htmlspecialchars($maestro['apellido_ma'] ?? ''); ?>" disabled>
                    </div>

                    <div class="profile-fields">
                        <label for="carrera">Carrera:</label>
                        <input type="text" id="carrera" name="carrera" value="<?php echo htmlspecialchars($maestro['carrera'] ?? ''); ?>" disabled>

                        <label for="telefono">Teléfono:</label>
                        <input type="tel" id="telefono" name="telefono" placeholder="Ingrese su teléfono" disabled>

                        <label for="correo">Correo:</label>
                        <input type="email" id="correo" name="correo" placeholder="Ingrese su correo institucional" disabled>

                        <label for="grado_academico">Grado Académico:</label>
                        <input type="text" id="grado_academico" name="grado_academico" placeholder="Ejemplo: Doctorado en Ciencias" disabled>
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
