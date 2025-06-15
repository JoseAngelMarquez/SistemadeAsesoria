<?php
// Se incluye el archivo que contiene la clase para manejar la autenticación de usuarios.
require_once __DIR__ . '/../model/UserAlumno.php';

class LoginController {

    // Método principal para manejar el inicio de sesión.
    public function login() {
        $message = ""; // Variable para almacenar el mensaje de error o éxito.

        // Verificar si la solicitud es un POST, es decir, si el formulario fue enviado.
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Se obtienen las credenciales del formulario (usuario y contraseña).
            $username = $_POST['user'];
            $password = $_POST['password'];

            // Se verifica el usuario y la contraseña en la base de datos llamando al método estático 'authenticateUser' de la clase 'User'.
            $id_user = User::authenticateUser($username, $password);

            // Si el usuario es autenticado correctamente, se inicia una nueva sesión.
            if ($id_user) {
                // Se inicia la sesión y se guarda el ID del usuario en la sesión.
                session_start();
                $_SESSION['user_id'] = $id_user;

                // Redirige al usuario a la página de inicio después de una autenticación exitosa.
                header("Location: /Proyecto_web/views/Alumnos/Inicio.php");
                exit(); // Se detiene la ejecución del código para evitar que continúe después de la redirección.
            } else {
                // Si la autenticación falla, se asigna un mensaje de error.
                $message = "Usuario no encontrado o contraseña incorrecta.";
            }
        }

        // Devuelve el mensaje de error (si lo hay) para mostrarlo en la vista.
        return $message;
    }
}
?>
