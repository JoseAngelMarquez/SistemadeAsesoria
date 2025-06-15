<?php
require_once __DIR__ . '/../config/db_config.php';

class AlumnoModel {
    private $conexion;

    // Constructor que recibe la conexión a la base de datos
    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    // Método para obtener los datos de un alumno según su user_id
    public function obtenerAlumno($userId) {
        try {
            // Consulta para obtener los datos del alumno
            $stmt = $this->conexion->prepare("SELECT * FROM alumnos WHERE user_id = ?");
            $stmt->bind_param("i", $userId);  // Vincula el parámetro user_id
            $stmt->execute();  // Ejecuta la consulta
            $result = $stmt->get_result();  // Obtiene el resultado

            // Si se encuentra el alumno, devuelve los datos como un array asociativo
            if ($result->num_rows > 0) {
                return $result->fetch_assoc();
            }
            return null;  // Si no se encuentra el alumno, retorna null
        } catch (Exception $e) {
            // Si ocurre algún error, lanza una excepción con el mensaje
            throw new Exception("Error al cargar el perfil: " . $e->getMessage());
        }
    }

    // Método para actualizar el perfil de un alumno
    public function actualizarPerfil($userId, $datos) {
        try {
            // Consulta para actualizar los datos del alumno
            $stmt = $this->conexion->prepare("UPDATE alumnos SET nombre = ?, apellido_pa = ?, apellido_ma = ?, grupo = ?, semestre = ?, email = ?, telefono = ?, direccion = ?, fecha_nacimiento = ?, licenciatura = ? WHERE user_id = ?");
            $stmt->bind_param("ssssssssssi", $datos['nombre'], $datos['apellido_pa'], $datos['apellido_ma'], $datos['grupo'], $datos['semestre'], $datos['email'], $datos['telefono'], $datos['direccion'], $datos['fecha_nacimiento'], $datos['licenciatura'], $userId);
            $stmt->execute();  // Ejecuta la consulta

            // Retorna true si la actualización fue exitosa
            return $stmt->affected_rows > 0;
        } catch (Exception $e) {
            // Si ocurre algún error, lanza una excepción con el mensaje
            throw new Exception("Error al actualizar el perfil: " . $e->getMessage());
        }
    }
}
?>
