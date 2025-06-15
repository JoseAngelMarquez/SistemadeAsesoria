<?php
// Se incluye el archivo que contiene la clase del modelo para manejar las encuestas.
require_once(__DIR__ . '/../model/EncuestaD.php');

// Inicia la sesión para poder utilizar variables de sesión.
session_start();

// Se obtiene el ID del usuario de la sesión actual.
$user_id = $_SESSION['user_id'];

// Se crea una instancia del modelo de preguntas, pasando la conexión a la base de datos.
$model = new PreguntaModel($conexion);

// Se define un array para almacenar las alertas que se mostrarán al usuario.
$alertas = [];

// Se verifica si la solicitud es de tipo POST.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Si se ha enviado una pregunta nueva, se procesa la información.
    if (isset($_POST['pregunta'])) {
        // Se obtiene el texto de la pregunta.
        $pregunta = $_POST['pregunta'];
        
        // Se obtienen las opciones de la pregunta, filtrando las vacías.
        $opciones = isset($_POST['opciones']) ? array_filter($_POST['opciones'], 'strlen') : [];
        
        // Se agrega la nueva pregunta junto con sus opciones al modelo.
        $model->agregarPregunta($pregunta, $opciones, $user_id);
        
        // Se agrega una alerta de éxito indicando que la pregunta fue agregada correctamente.
        $alertas[] = ['tipo' => 'success', 'mensaje' => 'Pregunta agregada correctamente'];
    }

    // Si se ha enviado una solicitud para asignar una pregunta a un alumno.
    if (isset($_POST['asignar_pregunta'])) {
        // Se obtiene el ID de la pregunta y la matrícula del alumno.
        $id_pregunta = $_POST['id_pregunta'];
        $alumno_matricula = $_POST['alumno_matricula'];
        
        // Se intenta asignar la pregunta al alumno. Si tiene éxito, se agrega una alerta de éxito.
        if ($model->asignarPregunta($id_pregunta, $alumno_matricula, $user_id)) {
            $alertas[] = ['tipo' => 'success', 'mensaje' => 'Pregunta asignada correctamente'];
        } else {
            // Si hubo un error, se agrega una alerta de error.
            $alertas[] = ['tipo' => 'error', 'mensaje' => 'Error al asignar la pregunta'];
        }
    }
}

// Se obtienen todas las preguntas del usuario.
$preguntas = $model->obtenerPreguntas($user_id);

// Se obtienen todos los alumnos para asignarles preguntas.
$alumnos = $model->obtenerAlumnos();
?>
