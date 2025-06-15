<?php
// Inicia la sesión para acceder a las variables de sesión.
session_start();

// Se incluye el archivo que contiene la clase para manejar la lógica del maestro (PerfilD.php).
require_once __DIR__ . '/../model/PerfilD.php';

// Verifica si el usuario ha iniciado sesión, si no, redirige al login de docentes.
if (!isset($_SESSION['user_id'])) {
    // Si no existe la variable de sesión 'user_id', redirige a la página de login de docentes.
    header('Location: /proyecto_web/views/login_Docente.php');
    exit; // Termina la ejecución del script después de redirigir.
}

// Se crea una instancia del modelo de maestro para interactuar con los datos del maestro.
$maestroModel = new Maestro();

// Obtiene el ID del usuario desde la variable de sesión.
$userId = $_SESSION['user_id'];
$message = ''; // Variable para almacenar mensajes de éxito o error.

// Obtener los datos del maestro utilizando el ID del usuario.
$maestro = $maestroModel->obtenerMaestroPorUsuario($userId);

// Verifica si los datos del maestro fueron encontrados.
if (!$maestro) {
    // Si no se encontraron datos, se asigna un mensaje de error.
    $message = "No se encontraron datos del maestro.";
}

// Procesa la actualización de datos del maestro cuando se recibe un formulario POST.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibe los datos enviados desde el formulario.
    $nombre = $_POST['nombre'];
    $apellido_pa = $_POST['apellido_pa'];
    $apellido_ma = $_POST['apellido_ma'];
    $carrera = $_POST['carrera'];

    // Intenta actualizar los datos del maestro en la base de datos.
    if ($maestroModel->actualizarMaestro($userId, $nombre, $apellido_pa, $apellido_ma, $carrera)) {
        // Si la actualización fue exitosa, se asigna un mensaje de éxito.
        $message = "Perfil actualizado con éxito.";
        // Se refrescan los datos del maestro después de la actualización.
        $maestro = $maestroModel->obtenerMaestroPorUsuario($userId);
    } else {
        // Si no hubo cambios, se asigna un mensaje indicando que no se realizaron cambios.
        $message = "No se realizaron cambios.";
    }
}
?>
