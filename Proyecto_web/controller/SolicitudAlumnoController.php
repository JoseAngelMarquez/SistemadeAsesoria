<?php
// Se incluye el archivo que contiene la clase AsesoriaModel, que maneja la lógica de la solicitud de asesoría.
require_once __DIR__ . '/../model/SolicitudA.php';

// Inicia la sesión para poder acceder a las variables de sesión
session_start();

// Verifica si el usuario ha iniciado sesión. Si no, redirige a la página de login de alumnos
if (!isset($_SESSION['user_id'])) {
    header("Location: /Proyecto_web/views/login_Alumno.php");
    exit();
}

// Se crea una nueva instancia de AsesoriaModel para interactuar con el modelo de asesorías
$asesoriaModel = new AsesoriaModel();

// Obtiene la lista de profesores disponibles para la solicitud de asesoría
$profesores = $asesoriaModel->obtenerProfesores();

// Verifica si el formulario fue enviado mediante el método POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Se obtienen los datos del formulario enviados por el usuario
    $matricula = $_POST['matricula']; // Matrícula del alumno
    $motivo = $_POST['motivo']; // Motivo por el cual se solicita la asesoría
    $fecha = $_POST['fecha']; // Fecha para la asesoría
    $tipo = $_POST['tipo']; // Tipo de asesoría (por ejemplo, académica, administrativa, etc.)
    $profesor = $_POST['profesor']; // Profesor seleccionado para la asesoría

    // Llama al método solicitarAsesoria del modelo para registrar la solicitud de asesoría en la base de datos
    if ($asesoriaModel->solicitarAsesoria($matricula, $motivo, $fecha, $tipo, $profesor)) {
        // Si la solicitud fue exitosa, muestra un mensaje de éxito y redirige a la misma página
        echo "<script>alert('Asesoría solicitada correctamente'); window.location.href='solicitar_asesoria.php';</script>";
    } else {
        // Si ocurre un error al procesar la solicitud, muestra un mensaje de error
        echo "<script>alert('Error al solicitar asesoría');</script>";
    }
}
?>
