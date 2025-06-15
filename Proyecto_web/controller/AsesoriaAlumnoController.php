<?php
// Inicia la sesión para poder utilizar variables de sesión.
session_start();

// Requiere el archivo que contiene la clase del modelo para manejar las asesorías.
require_once(__DIR__ . "/../model/AsesoriasA.php");

class AsesoriasController {

    // Se declara una variable privada para almacenar el modelo de Asesorías.
    private $model;

    // Constructor de la clase, recibe la conexión a la base de datos y la pasa al modelo.
    public function __construct($conexion) {
        $this->model = new AsesoriasModel($conexion);
    }

    // Método para mostrar el historial de asesorías del usuario.
    public function mostrarHistorial() {
        // Obtiene el ID del usuario desde la sesión actual.
        $user_id = $_SESSION['user_id'];

        // Obtiene la matrícula del alumno a partir del ID de usuario.
        $matricula_alumno = $this->model->obtenerMatriculaAlumno($user_id);

        // Configuración de la paginación: se establecen los valores del límite de registros por página.
        $limit = 5; // Número máximo de registros a mostrar por página.
        
        // Se obtiene el número de página actual, o se asigna la página 1 si no está definida.
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        
        // Se calcula el desplazamiento (offset) según la página actual y el límite de registros.
        $offset = ($page - 1) * $limit;

        // Se obtienen los registros del historial de asesorías, pasando la matrícula, límite y offset.
        $historial = $this->model->obtenerHistorialAsesorias($matricula_alumno, $limit, $offset);
        
        // Se obtiene el total de asesorías del alumno para calcular el número total de páginas.
        $total = $this->model->obtenerTotalAsesorias($matricula_alumno);
        
        // Se calcula el número total de páginas basado en el total de registros y el límite por página.
        $total_pages = ceil($total / $limit);

        // Retorna un arreglo con el historial de asesorías, el número total de páginas y la página actual.
        return [
            'historial' => $historial,
            'total_pages' => $total_pages,
            'current_page' => $page
        ];
    }
}
?>
