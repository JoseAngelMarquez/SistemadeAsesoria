<?php
// ControladorEncuesta.php

// Se incluye el archivo que contiene la clase del modelo para manejar las encuestas.
require_once(__DIR__ . "/../model/EncuestaA.php");

class ControladorEncuesta {
    // Se declara una variable privada para almacenar el modelo de Encuesta.
    private $modelo;

    // Constructor de la clase, recibe la conexión a la base de datos y la pasa al modelo.
    public function __construct($conexion) {
        // Se crea una instancia del modelo, pasando la conexión a la base de datos.
        $this->modelo = new ModeloEncuesta($conexion);
    }

    // Método para obtener el ID del alumno basado en su ID de usuario.
    public function obtenerAlumnoId($user_id) {
        // Llama al método del modelo para obtener los datos del alumno utilizando el ID de usuario.
        return $this->modelo->obtenerAlumno($user_id);
    }

    // Método para obtener las preguntas relacionadas con un alumno, según su ID.
    public function obtenerPreguntas($alumno_id) {
        // Llama al método del modelo para obtener las preguntas de la encuesta relacionadas con el alumno.
        return $this->modelo->obtenerPreguntas($alumno_id);
    }

    // Método para obtener todos los maestros.
    public function obtenerMaestros() {
        // Llama al método del modelo para obtener la lista de maestros.
        return $this->modelo->obtenerMaestros();
    }

    // Método para procesar las respuestas de una encuesta.
    public function procesarRespuestas($preguntas, $maestro_id, $alumno_id) {
        // Se recorre el array de preguntas.
        foreach ($preguntas as $pregunta) {
            // Se obtiene la respuesta seleccionada por el alumno para cada pregunta, si existe.
            $respuesta_id = isset($_POST['respuesta_' . $pregunta['id']]) ? $_POST['respuesta_' . $pregunta['id']] : null;
            
            // Si se ha seleccionado una respuesta, se inserta en la base de datos.
            if ($respuesta_id) {
                // Llama al método del modelo para insertar la respuesta en la base de datos.
                $this->modelo->insertarRespuestas($pregunta['id'], $respuesta_id, $alumno_id, $maestro_id);
            }
        }
    }
}
?>
