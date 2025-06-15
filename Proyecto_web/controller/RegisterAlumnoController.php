<?php
// Se incluye el archivo que contiene la clase Alumno, que maneja la lógica de registro.
require_once __DIR__ . '/../model/RegisterA.php';

class AlumnoController {
    // Método para registrar a un nuevo alumno
    public function registrar() {
        // Verifica si el formulario fue enviado mediante el método POST
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Se obtiene la información del formulario y se almacena en un array
            $data = [
                'matricula' => $_POST['matricula'], // Matrícula del alumno
                'username' => $_POST['user'], // Usuario (nombre de usuario)
                'password' => $_POST['password'], // Contraseña para el acceso del alumno
                'nombre' => $_POST['nombre'], // Nombre del alumno
                'apellido_pa' => $_POST['apellido_pa'], // Apellido paterno del alumno
                'apellido_ma' => $_POST['apellido_ma'], // Apellido materno del alumno
                'grupo' => $_POST['grupo'], // Grupo al que pertenece el alumno
                'semestre' => $_POST['semestre'], // Semestre en el que está inscrito
                'fecha_nacimiento' => $_POST['fecha_nacimiento'], // Fecha de nacimiento del alumno
                'licenciatura' => $_POST['licenciatura'], // Licenciatura que cursa el alumno
                'email' => $_POST['email'], // Correo electrónico del alumno
                'telefono' => $_POST['telefono'], // Teléfono del alumno
                'direccion' => $_POST['direccion'] // Dirección del alumno
            ];

            // Se crea una nueva instancia de la clase Alumno
            $alumno = new Alumno();
            // Llama al método registrarAlumno del modelo para registrar al alumno en la base de datos
            return $alumno->registrarAlumno($data);
        }

        // Si el formulario no fue enviado, se retorna una cadena vacía
        return "";
    }
}
?>
