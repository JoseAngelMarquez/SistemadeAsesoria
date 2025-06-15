<?php
require_once(__DIR__ . "/../config/db_config.php");

class AsesoriasModel {

    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    // Obtener la matrícula del alumno
    public function obtenerMatriculaAlumno($user_id) {
        $query_alumno = "SELECT matricula FROM alumnos WHERE user_id = ?";
        $stmt_alumno = $this->conexion->prepare($query_alumno);
        $stmt_alumno->bind_param("i", $user_id);
        $stmt_alumno->execute();
        $result_alumno = $stmt_alumno->get_result();
        $alumno = $result_alumno->fetch_assoc();
        return $alumno['matricula'];
    }

    // Obtener historial de asesorías con paginación
    public function obtenerHistorialAsesorias($matricula_alumno, $limit, $offset) {
        $query_historial = "
            SELECT a.fecha_asesoria, 
                   a.tipo_asesoria, 
                   a.motivo_asesoria, 
                   CONCAT(m.nombre, ' ', m.apellido_pa, ' ', m.apellido_ma) AS maestro
            FROM asesorias a
            JOIN maestros m ON a.maestro_id = m.matricula
            WHERE a.matricula_alumno = ?
            LIMIT ? OFFSET ?
        ";
        $stmt_historial = $this->conexion->prepare($query_historial);
        $stmt_historial->bind_param("iii", $matricula_alumno, $limit, $offset);
        $stmt_historial->execute();
        return $stmt_historial->get_result();
    }

    // Obtener el número total de asesorías para la paginación
    public function obtenerTotalAsesorias($matricula_alumno) {
        $query_total = "
            SELECT COUNT(*) AS total
            FROM asesorias a
            WHERE a.matricula_alumno = ?
        ";
        $stmt_total = $this->conexion->prepare($query_total);
        $stmt_total->bind_param("i", $matricula_alumno);
        $stmt_total->execute();
        $result_total = $stmt_total->get_result();
        return $result_total->fetch_assoc()['total'];
    }
}
?>
