<?php
require_once __DIR__ . '/../config/db_config.php';

/**
 * Clase Maestro para gestionar registros de maestros.
 */
class Maestro {
    private $conn;

    public function __construct() {
        $this->conn = Database::connect(); // Conecta a la base de datos
    }

    // Obtiene los datos de un maestro por user_id
    public function obtenerMaestroPorUsuario($userId) {
        $stmt = $this->conn->prepare("SELECT * FROM maestros WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Actualiza los datos del maestro
    public function actualizarMaestro($userId, $nombre, $apellido_pa, $apellido_ma, $carrera) {
        $stmt = $this->conn->prepare("UPDATE maestros SET nombre = ?, apellido_pa = ?, apellido_ma = ?, carrera = ? WHERE user_id = ?");
        $stmt->bind_param("ssssi", $nombre, $apellido_pa, $apellido_ma, $carrera, $userId);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
}
?>
