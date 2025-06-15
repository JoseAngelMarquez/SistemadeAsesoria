<?php
require_once __DIR__ . '/../config/db_config.php';

class PreguntaModel {
    private $conexion;

    // Constructor que recibe la conexión a la base de datos
    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    // Método para agregar una nueva pregunta y sus opciones a la base de datos
    public function agregarPregunta($pregunta, $opciones, $user_id) {
        // Insertar la pregunta en la tabla de preguntas
        $stmt = $this->conexion->prepare("INSERT INTO preguntas (pregunta, user_id) VALUES (?, ?)");
        $stmt->bind_param('si', $pregunta, $user_id);
        $stmt->execute();
        $id_pregunta = $stmt->insert_id;  // Obtener el ID de la pregunta recién insertada
        $stmt->close();

        // Insertar las opciones correspondientes a la pregunta
        foreach ($opciones as $opcion) {
            if (!empty(trim($opcion))) {  // Verificar que la opción no esté vacía
                $stmt = $this->conexion->prepare("INSERT INTO opciones (id_pregunta, opcion) VALUES (?, ?)");
                $stmt->bind_param('is', $id_pregunta, $opcion);
                $stmt->execute();
                $stmt->close();
            }
        }

        return $id_pregunta;  // Retorna el ID de la pregunta insertada
    }

    // Método para obtener todas las preguntas de un usuario específico
    public function obtenerPreguntas($user_id) {
        $stmt = $this->conexion->prepare("SELECT * FROM preguntas WHERE user_id = ?");
        $stmt->bind_param('i', $user_id);  // Filtra las preguntas por el user_id
        $stmt->execute();
        $result = $stmt->get_result();
        $preguntas = $result->fetch_all(MYSQLI_ASSOC);  // Obtener todas las preguntas como un array asociativo
        $stmt->close();
        return $preguntas;  // Devuelve las preguntas
    }

    // Método para obtener todos los alumnos
    public function obtenerAlumnos() {
        $stmt = $this->conexion->prepare("SELECT matricula, nombre, apellido_pa FROM alumnos");
        $stmt->execute();
        $result = $stmt->get_result();
        $alumnos = $result->fetch_all(MYSQLI_ASSOC);  // Obtener todos los alumnos
        $stmt->close();
        return $alumnos;  // Devuelve los alumnos
    }

    // Método para asignar una pregunta a un alumno
    public function asignarPregunta($pregunta_id, $alumno_id, $user_id) {
        $stmt = $this->conexion->prepare("INSERT INTO asignaciones (pregunta_id, alumno_id, user_id) VALUES (?, ?, ?)");
        $stmt->bind_param('iii', $pregunta_id, $alumno_id, $user_id);  // Asignación de los parámetros
        $stmt->execute();
        $success = $stmt->affected_rows > 0;  // Verificar si la inserción fue exitosa
        $stmt->close();
        return $success;  // Devuelve true si la asignación fue exitosa
    }
}
?>
