
<?php
// Iniciar la sesión
session_start();

// Verificar si la sesión está activa
if (!isset($_SESSION['user_id'])) {
    // Redirigir al usuario a la página de inicio de sesión si no está autenticado
    header("Location: /Proyecto_web/views/login_Alumno.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/Proyecto_web/assets/cssalumno/inicio.css">
    <link rel="stylesheet" href="/Proyecto_web/assets/css/esqueleto.css">

    
    <title>Página principal de asesorías</title>
  
</head>

<body>
    <div class="container">
        <!-- Menú lateral izquierdo -->
        <nav class="sidebar">
            <ul>
                <li><a href="inicio.php"><i class="fas fa-home"></i> Inicio</a></li>
                <li><a href="Solicitar_asesoria.php"><i class="fas fa-chart-line"></i> Solicitar asesorias</a></li>
                <li><a href="misasesorias.php"><i class="fas fa-users"></i> Mis asesorías</a></li>
                <li><a href="encuesta.php"><i class="fas fa-cogs"></i> Encuesta</a></li>
                <li><a href="perfil.php"><i class="fas fa-question-circle"></i> Perfil</a></li>
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
                    <i class="fas fa-user-circle avatar"></i>
                    <button class="user-button" >Perfil</button>
                </div>
            </div>

            <!-- Resto del contenido -->
            <div class="content">
                <h1>Bienvenido</h1>

                <!-- Tarjetas -->
                <div class="card-container">
                    <div class="card">
                        <i class="fas fa-chart-pie"></i>
                        <h3>Estadísticas</h3>
                        <p>Visualiza las estadísticas de uso.</p>
                    </div>
                    <div class="card">
                        <i class="fa-solid fa-calendar-days"></i>
                        <h3>Fechas</h3>
                        <p>Citas endientes</p>
                    </div>
                    <div class="card">
                        <i class="fa-solid fa-folder-open"></i>
                        <h3>Archivos</h3>
                        <p>Archivos o notas</p>
                    </div>
                </div>

                <!-- Gráfica -->
                <div class="chart-container">
                    <div class="chart">
                        Gráfica de Datos (Por implementar)
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
