<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/Proyecto_web/assets/css/seccion2.css">
    <title>Solicitar Asesoría</title>
</head>

<body>
    <div class="container">
        <nav class="sidebar">
            <ul>
            <li><a href="inicio.php"><i class="fas fa-home"></i> Inicio</a></li>
                <li><a href="Solicitar_asesoria.php"><i class="fas fa-chart-line"></i> Solicitar asesorias</a></li>
                <li><a href="misasesorias.php"><i class="fas fa-users"></i> Mis asesorías</a></li>
                <li><a href="encuesta.php"><i class="fas fa-cogs"></i> Encuesta</a></li>
                <li><a href="perfil.php"><i class="fas fa-question-circle"></i> Perfil</a></li>            </ul>
            <div class="logout">
                <a href="#"><i class="fas fa-sign-out-alt"></i> Salir</a>
            </div>
        </nav>

        <div class="main-content">
            <div class="top-bar">
                <div class="logo-section">
                    <i class="fas fa-laptop-code"></i>
                    <span class="software-name">UNSIS BOOST</span>
                </div>
                <div class="user-section">
                    <i class="fas fa-user-circle avatar"></i>
                    <button class="user-button">Perfil</button>
                </div>
            </div>

            <div class="content">
                <h1>Solicitar Asesoría</h1>

                <div class="form-container">
                    <form action="procesar_solicitud_rendimiento.php" method="POST">
                        <!-- Campo para el nombre del alumno -->
                        <div class="form-group">
                            <label for="nombre">Nombre del Alumno:</label>
                            <input type="text" id="nombre" name="nombre" required>
                        </div>

                        <!-- Campo para la matrícula del alumno -->
                        <div class="form-group">
                            <label for="matricula">Matrícula:</label>
                            <input type="text" id="matricula" name="matricula" required>
                        </div>

                        <!-- Campo para seleccionar el tipo de asesoría -->
                        <div class="form-group">
                            <label for="tipo">Tipo de Asesoría:</label>
                            <select id="tipo" name="tipo" required>
                                <option value="">Selecciona el tipo de asesoría</option>
                                <option value="personal">Personal</option>
                                <option value="academica">Académica</option>
                                <option value="psicologica">Psicológica</option>
                            </select>
                        </div>

                        <!-- Campo para el motivo o descripción de la solicitud -->
                        <div class="form-group">
                            <label for="motivo">Motivo de la Asesoría:</label>
                            <textarea id="motivo" name="motivo" rows="4" required></textarea>
                        </div>

                        <!-- Campo para la fecha solicitada -->
                        <div class="form-group">
                            <label for="fecha">Fecha de la Asesoría:</label>
                            <input type="date" id="fecha" name="fecha" required>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="submit-button">Solicitar Asesoría</button>
                            <button type="submit" class="cancel-button">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
