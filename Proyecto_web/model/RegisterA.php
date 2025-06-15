<?php
require_once __DIR__ . '/../config/db_config.php'; // Incluir la conexión

class Alumno {
    private $conn;

    public function __construct() {
        global $conexion; // Usar la conexión global definida en db_config.php
        $this->conn = $conexion; // Asignar la conexión
    }

    public function registrarAlumno($data) {
        $this->conn->begin_transaction(); // Iniciar una transacción

        try {
            // Obtener el role_id para el rol "Alumno"
            $stmt = $this->conn->prepare("SELECT id FROM roles WHERE nombre = ?");
            $roleName = "Alumno";
            $stmt->bind_param("s", $roleName);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 0) {
                throw new Exception("El rol 'Alumno' no existe.");
            }

            $role = $result->fetch_assoc();
            $roleId = $role['id'];

            // Hashear la contraseña antes de almacenarla
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

            // Insertar en la tabla users
            $stmt = $this->conn->prepare("INSERT INTO users (username, password, role_id) VALUES (?, ?, ?)");
            $stmt->bind_param("ssi", $data['username'], $hashedPassword, $roleId);
            $stmt->execute();
            $userId = $this->conn->insert_id; // Obtener el ID del usuario insertado

            // Insertar en la tabla alumnos
            $stmt = $this->conn->prepare("INSERT INTO alumnos (matricula, nombre, apellido_pa, apellido_ma, grupo, semestre, user_id, fecha_nacimiento, licenciatura, email, telefono, direccion) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("isssssssssss", 
                $data['matricula'], $data['nombre'], $data['apellido_pa'], $data['apellido_ma'], 
                $data['grupo'], $data['semestre'], $userId, $data['fecha_nacimiento'], 
                $data['licenciatura'], $data['correo'], $data['telefono'], $data['direccion']
            );
            $stmt->execute();

            $this->conn->commit(); 
            return "Registro exitoso. Puedes iniciar sesión."; // Mensaje de éxito
        } catch (Exception $e) {
            $this->conn->rollback(); // Rollback si ocurre un error
            return "Error al registrar el alumno: " . $e->getMessage(); // Mensaje de error
        }
    }
}

?>
