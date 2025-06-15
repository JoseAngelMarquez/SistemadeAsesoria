<?php
require_once __DIR__ . '/../../config/db_config.php';
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: /Proyecto_web/views/Docentes/login_Docente.php");
    exit();
}

// Obtener el ID del usuario desde la sesión (esto es el id_user de la tabla users)
$id_user = $_SESSION['user_id'];

// Consulta para obtener la matrícula del maestro asociado al usuario logueado
$sql_maestro = "SELECT matricula FROM maestros WHERE user_id = ?";
$stmt = $conexion->prepare($sql_maestro);
$stmt->bind_param("i", $id_user);
$stmt->execute();
$result = $stmt->get_result();
$maestro = $result->fetch_assoc();

// Si se encuentra la matrícula del maestro
if ($maestro) {
    $maestro_id = $maestro['matricula'];

    // Consulta para obtener las asesorías asignadas al maestro
    $sql_asesorias = "
        SELECT 
            al.nombre AS nombre_alumno, 
            al.apellido_pa AS apellido_pa, 
            al.apellido_ma AS apellido_ma, 
            asr.motivo_asesoria, 
            asr.fecha_asesoria, 
            asr.tipo_asesoria 
        FROM asesorias asr
        INNER JOIN alumnos al ON asr.matricula_alumno = al.matricula
        WHERE asr.maestro_id = ?
    ";

    $stmt = $conexion->prepare($sql_asesorias);
    $stmt->bind_param("i", $maestro_id);
    $stmt->execute();
    $result_asesorias = $stmt->get_result();
} else {
    echo "No se encontró la matrícula del maestro.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Asesorías</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/Proyecto_web/assets/cssdocente/solicitudes.css">
    <link rel="stylesheet" href="/Proyecto_web/assets/css/esqueleto.css">
</head>

<body>
    <div class="container">
        <nav class="sidebar">
            <ul>
                <li><a href="inicio.php"><i class="fas fa-home"></i> Inicio</a></li>
                <li><a href="Solicitar_asesoria.php"><i class="fas fa-chart-line"></i> Asesorías</a></li>
                <li><a href="encuesta.php"><i class="fas fa-cogs"></i> Encuesta</a></li>
                <li><a href="perfil.php"><i class="fas fa-question-circle"></i> Perfil</a></li>
                <li><a href="misasesorias.php"><i class="fas fa-users"></i> Reportes</a></li>
            </ul>
            <div class="logout">
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Salir</a>
            </div>
        </nav>

        <div class="main-content">
            <div class="top-bar">
                <div class="logo-section">
                <img class="unsis" src="/Proyecto_web/assets/img/unsis.png" alt="">
                <span class="software-name">UNSIS BOOST</span>
                </div>
                <div class="user-section">
                    <i class="fas fa-user-circle avatar"></i>
                    <button class="user-button">Perfil</button>
                </div>
            </div>

            <div class="content">
                <h1>Mis Asesorías Solicitadas</h1>

                <div class="table-container">
                    <table border="1">
                        <thead>
                            <tr>
                                <th>Nombre Alumno</th>
                                <th>Motivo</th>
                                <th>Fecha</th>
                                <th>Tipo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Mostrar las asesorías obtenidas
                            if ($result_asesorias && $result_asesorias->num_rows > 0) {
                                while ($row = $result_asesorias->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>{$row['nombre_alumno']} {$row['apellido_pa']} {$row['apellido_ma']}</td>";
                                    echo "<td>{$row['motivo_asesoria']}</td>";
                                    echo "<td>{$row['fecha_asesoria']}</td>";
                                    echo "<td>{$row['tipo_asesoria']}</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4'>No se encontraron asesorías asignadas.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
