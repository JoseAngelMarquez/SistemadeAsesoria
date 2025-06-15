<?php
// Se incluye el archivo que contiene la clase para manejar la lógica de los alumnos (PerfilA.php).
require_once(__DIR__ . "/../model/PerfilA.php");

class AlumnoController {
    private $alumnoModel; // Variable para almacenar la instancia del modelo de alumno.

    // Constructor que recibe la conexión y crea una instancia del modelo de alumno.
    public function __construct($conexion) {
        $this->alumnoModel = new AlumnoModel($conexion); // Se crea la instancia del modelo para acceder a los datos del alumno.
    }

    // Método para obtener el perfil de un alumno a partir de su ID de usuario.
    public function perfil($userId) {
        $message = ''; // Variable para almacenar el mensaje de error o éxito.
        $alumno = null; // Inicializa la variable que almacenará los datos del alumno.

        try {
            // Se intenta recuperar los datos del alumno desde la base de datos.
            $alumno = $this->alumnoModel->obtenerAlumno($userId);
        } catch (Exception $e) {
            // Si ocurre un error, se captura la excepción y se guarda el mensaje de error.
            $message = $e->getMessage();
        }

        // Se devuelve un array con los datos del alumno y el mensaje de error (si hay).
        return ['alumno' => $alumno, 'message' => $message];
    }

    // Método para actualizar los datos del perfil de un alumno.
    public function actualizarPerfil($userId, $datos) {
        $message = ''; // Variable para almacenar el mensaje de éxito o error.
        try {
            // Se intenta actualizar los datos del alumno en la base de datos.
            $exito = $this->alumnoModel->actualizarPerfil($userId, $datos);
            // Si la actualización fue exitosa, se establece un mensaje de éxito.
            if ($exito) {
                $message = "Perfil actualizado con éxito.";
            } else {
                // Si no hubo cambios, se establece un mensaje indicando que no se realizaron cambios.
                $message = "No se realizaron cambios.";
            }
        } catch (Exception $e) {
            // Si ocurre un error, se captura la excepción y se guarda el mensaje de error.
            $message = $e->getMessage();
        }

        // Se devuelve el mensaje correspondiente.
        return $message;
    }
}
?>
