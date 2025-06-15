<?php
// encuesta.php

require_once(__DIR__ . "/../../controller/EncuestaAlumnoController.php");
session_start();

// Conexión a la base de datos
require_once(__DIR__ . "/../../config/db_config.php");

$user_id = $_SESSION['user_id']; // ID del usuario logueado

// Crear instancia del controlador
$controlador = new ControladorEncuesta($conexion);

// Obtener el ID del alumno asociado al usuario logueado
$alumno = $controlador->obtenerAlumnoId($user_id);
$alumno_id = $alumno['matricula']; // ID del alumno

// Obtener las preguntas asignadas al alumno
$preguntas = $controlador->obtenerPreguntas($alumno_id);

// Procesar respuestas cuando se envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $maestro_id = $_POST['maestro_id'];
    $controlador->procesarRespuestas($preguntas, $maestro_id, $alumno_id);
    echo "<script type='text/javascript'>alert('Respuestas enviadas con éxito.');</script>";
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/Proyecto_web/assets/css/esqueleto.css">
    <link rel="stylesheet" href="/Proyecto_web/assets/cssalumno/encuesta.css">
    <title>Encuesta del alumno</title>
</head>

<body>
    <div class="container">
        <nav class="sidebar">
            <ul>
                <li><a href="inicio.php"><i class="fas fa-home"></i> Inicio</a></li>
                <li><a href="Solicitar_asesoria.php"><i class="fas fa-chart-line"></i> Solicitar asesorías</a></li>
                <li><a href="misasesorias.php"><i class="fas fa-users"></i> Mis asesorias</a></li>
                <li><a href="encuesta.php"><i class="fas fa-cogs"></i> Encuesta</a></li>
                <li><a href="perfil.php"><i class="fas fa-question-circle"></i> Perfil</a></li>
            </ul>
            <div class="logout">
                <a href="#"><i class="fas fa-sign-out-alt"></i> Salir</a>
            </div>
        </nav>

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
            <h1>Encuesta</h1>

            <div class="content">
                <form action="encuesta.php" method="POST">
                    <label for="maestro_id">Selecciona un maestro:</label>
                    <select name="maestro_id" required>
                        <option value="">Seleccione un maestro</option>
                        <?php
                        $maestros = $controlador->obtenerMaestros();
                        while ($maestro = $maestros->fetch_assoc()) {
                            echo '<option value="' . $maestro['matricula'] . '">' . $maestro['nombre'] . ' ' . $maestro['apellido_pa'] . ' ' . $maestro['apellido_ma'] . '</option>';
                        }
                        ?>
                    </select>

                    <div class="preguntas">
                        <?php
                        if (count($preguntas) > 0) {
                            foreach ($preguntas as $pregunta) {
                                echo '<div class="card pregunta">';
                                echo '<div class="card-header"><strong>' . $pregunta['pregunta'] . '</strong></div>';
                                echo '<div class="card-body">';

                                // Obtener las opciones de cada pregunta
                                $query_opciones = "SELECT * FROM opciones WHERE id_pregunta = ?";
                                $stmt_opciones = $conexion->prepare($query_opciones);
                                $stmt_opciones->bind_param("i", $pregunta['id']);
                                $stmt_opciones->execute();
                                $opciones_result = $stmt_opciones->get_result();

                                while ($opcion = $opciones_result->fetch_assoc()) {
                                    echo '<div class="option">';
                                    echo '<input type="radio" name="respuesta_' . $pregunta['id'] . '" value="' . $opcion['id'] . '" id="opcion_' . $opcion['id'] . '">';
                                    echo '<label for="opcion_' . $opcion['id'] . '">' . $opcion['opcion'] . '</label>';
                                    echo '</div>';
                                }
                                echo '</div>';
                                echo '</div>';
                            }
                        } else {
                            echo '<p>No tienes preguntas asignadas.</p>';
                        }
                        ?>
                    </div>

                    <button type="submit" class="button1">Enviar</button>
                    <button type="button" class="button2">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
