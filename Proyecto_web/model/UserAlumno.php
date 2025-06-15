<?php
require_once __DIR__ . '/../config/db_config.php'; 

class User {
    public static function authenticateUser($username, $password) {
        global $conexion;

        // Preparar la consulta SQL para verificar el usuario
        $stmt = $conexion->prepare("SELECT id, password, role_id FROM users WHERE username = ? AND role_id = 3");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id_user, $hashedPassword, $roleId);

        if ($stmt->num_rows > 0) {
            $stmt->fetch();
            // Verificar la contraseña
            if (password_verify($password, $hashedPassword)) {
                return $id_user; // El usuario está autenticado
            }
        }
        // Usuario no encontrado o contraseña incorrecta
        return null; 
    }
}

?>
