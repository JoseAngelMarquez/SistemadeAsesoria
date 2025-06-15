<?php
require_once __DIR__ . '/../config/db_config.php';

class AsesoriaModel {
    private $conexion;

    public function __construct() {
        $this->conexion = $this->conectar(); // Conectar a la base de datos
    }

    private function conectar() {
        global $conexion; // Usar la conexión global
        return $conexion; // Retornar la conexión
    }

    public function obtenerProfesores() {
        $query = "SELECT matricula, nombre, apellido_pa, apellido_ma FROM maestros"; // Consulta para obtener profesores
        $result = mysqli_query($this->conexion, $query); // Ejecutar consulta
        return $result ? mysqli_fetch_all($result, MYSQLI_ASSOC) : []; // Devolver los resultados como array
    }

    public function solicitarAsesoria($matricula, $motivo, $fecha, $tipo, $profesor) {
        $query = "INSERT INTO asesorias (matricula_alumno, motivo_asesoria, fecha_asesoria, tipo_asesoria, maestro_id) 
                  VALUES ('$matricula', '$motivo', '$fecha', '$tipo', '$profesor')"; // Consulta para insertar asesoría
        return mysqli_query($this->conexion, $query); // Ejecutar la consulta de inserción
    }
}
?>
