<?php
// ModeloEncuesta.php

// Se incluye la configuración de la base de datos
require_once(__DIR__ . "/../config/db_config.php");

class ModeloEncuesta {
    private $conexion;

    // Constructor que recibe la conexión a la base de datos
    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    // Método para obtener la matrícula del alumno según su ID de usuario
    public function obtenerAlumno($user_id) {
        $query = "SELECT matricula FROM alumnos WHERE user_id = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("i", $user_id);  // "i" indica que el parámetro es un entero
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();  // Devuelve el resultado como un array asociativo
    }

    // Método para obtener las preguntas asignadas al alumno
    public function obtenerPreguntas($alumno_id) {
        $query = "
            SELECT p.id, p.pregunta
            FROM asignaciones a
            JOIN preguntas p ON a.pregunta_id = p.id
            WHERE a.alumno_id = ?
        ";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("i", $alumno_id);  // "i" indica que el parámetro es un entero
        $stmt->execute();
        $result = $stmt->get_result();
        $preguntas = [];
        // Recorre el resultado y almacena las preguntas en un array
        while ($row = $result->fetch_assoc()) {
            $preguntas[] = $row;
        }
        return $preguntas;  // Devuelve un array con todas las preguntas
    }

    // Método para obtener todos los maestros
    public function obtenerMaestros() {
        $query = "SELECT matricula, nombre, apellido_pa, apellido_ma FROM maestros";
        $result = $this->conexion->query($query);  // Se ejecuta la consulta sin parámetros
        return $result;  // Devuelve el resultado
    }

    // Método para insertar una respuesta en la base de datos
    public function insertarRespuestas($pregunta_id, $respuesta_id, $alumno_id, $maestro_id) {
        $query = "INSERT INTO respuestas (id_pregunta, id_opcion, alumno_id, maestro_id) VALUES (?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("iiii", $pregunta_id, $respuesta_id, $alumno_id, $maestro_id);  // "iiii" indica que los parámetros son enteros
        $stmt->execute();  // Ejecuta la consulta para insertar los datos
    }
}
?>
