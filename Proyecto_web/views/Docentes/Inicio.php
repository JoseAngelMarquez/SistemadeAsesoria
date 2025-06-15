<?php
session_start(); // Iniciar sesión

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: /Proyecto_web/views/login_Docente.php");
    exit();
}

// Obtener el ID del usuario desde la sesión
$user_id = $_SESSION['user_id'];

// Conectar con la base de datos
require_once(__DIR__ . "/../../config/db_config.php");

// Obtener la matrícula del maestro usando el user_id
$query_maestro_matricula = "
    SELECT m.matricula
    FROM maestros m
    JOIN users u ON u.id = m.user_id  -- Relacionamos el ID de usuario con el user_id del maestro
    WHERE u.id = ?;
";

if ($stmt = $conexion->prepare($query_maestro_matricula)) {
    $stmt->bind_param("i", $user_id); // Vincular el user_id de la sesión
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $maestro_matricula = $row['matricula'];
    } else {
        echo "<script type='text/javascript'>alert('No se encontro la matricula del maestro.');</script>";
        exit();
    }

    $stmt->close();
} else {
    echo "Error en la consulta SQL para obtener la matrícula del maestro.";
    exit();
}

// Consultar los alumnos relacionados con el maestro
$query_alumnos = "
    SELECT a.matricula, a.nombre, a.apellido_pa, a.apellido_ma, a.licenciatura
    FROM alumnos a
    JOIN respuestas r ON r.alumno_id = a.matricula
    WHERE r.maestro_id = ? 
    GROUP BY a.matricula;
";

if ($stmt = $conexion->prepare($query_alumnos)) {
    $stmt->bind_param("i", $maestro_matricula);
    $stmt->execute();
    $result = $stmt->get_result();

    $alumnos = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $alumnos[] = $row;
        }
    } else {
        echo "<script type='text/javascript'>alert('No se encontraron alumnos.');</script>";
    }

    $stmt->close();
} else {
    echo "<script type='text/javascript'>alert('Error en sql.');</script>";
    exit();
}

//Paginación
$registros_por_pagina = 8;
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$inicio = ($pagina - 1) * $registros_por_pagina;

// Obtener el alumno_id si está en el formulario
$alumno_id = isset($_POST['alumno_id']) ? $_POST['alumno_id'] : (isset($_GET['alumno_id']) ? $_GET['alumno_id'] : null);

// Si se selecciona un alumno, mostrar sus respuestas
$respuestas = [];
if ($alumno_id) {
    // Consulta para obtener las respuestas con paginación
    $query_respuestas = "
        SELECT p.pregunta, o.opcion, a.nombre AS alumno_nombre, a.matricula, a.apellido_pa, a.apellido_ma, a.licenciatura
        FROM respuestas r
        JOIN preguntas p ON r.id_pregunta = p.id
        JOIN opciones o ON r.id_opcion = o.id
        JOIN alumnos a ON r.alumno_id = a.matricula
        WHERE r.maestro_id = ? AND a.matricula = ?
        LIMIT ?, ?;
    ";

    if ($stmt = $conexion->prepare($query_respuestas)) {
        $stmt->bind_param("iiii", $maestro_matricula, $alumno_id, $inicio, $registros_por_pagina);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $respuestas[] = $row;
            }
        } else {
            echo "No se encontraron respuestas para este alumno.";
        }

        $stmt->close();
    } else {
        echo "Error en la consulta SQL para obtener las respuestas.";
    }

    // Contar el número total de respuestas para este alumno
    $query_total_respuestas = "
        SELECT COUNT(*) AS total
        FROM respuestas r
        JOIN alumnos a ON r.alumno_id = a.matricula
        WHERE r.maestro_id = ? AND a.matricula = ?;
    ";

    if ($stmt = $conexion->prepare($query_total_respuestas)) {
        $stmt->bind_param("ii", $maestro_matricula, $alumno_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $total_respuestas = $row['total'];

        // Calcular el número total de páginas
        $total_paginas = ceil($total_respuestas / $registros_por_pagina);
    } else {
        echo "Error en la consulta SQL para contar las respuestas.";
    }
}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/Proyecto_web/assets/css/esqueleto.css">
    <link rel="stylesheet" href="/Proyecto_web/assets/cssdocente/Iniciodocente.css">
    <title>Respuestas de Alumnos</title>
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

            <form method="POST" action="">
                <label for="alumno_id">Selecciona un alumno:</label>
                <select name="alumno_id" id="alumno_id" onchange="this.form.submit()">
                    <option value="">Seleccionar alumno</option>
                    <?php foreach ($alumnos as $alumno): ?>
                        <option value="<?php echo $alumno['matricula']; ?>" <?php echo (isset($alumno_id) && $alumno_id == $alumno['matricula']) ? 'selected' : ''; ?>>
                            <?php echo $alumno['nombre']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>

            <div class="content">
                <h1>Respuestas de Alumnos</h1>

                <?php if (count($respuestas) > 0): ?>
                    <table class="results-table">
                        <thead>
                            <tr>
                                <th>Alumno</th>
                                <th>Apellido Paterno</th>
                                <th>Apellido Materno</th>
                                <th>Licenciatura</th>
                                <th>Pregunta</th>
                                <th>Respuesta</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($respuestas as $respuesta): ?>
                                <tr>
                                    <td><?php echo $respuesta['alumno_nombre']; ?></td>
                                    <td><?php echo $respuesta['apellido_pa']; ?></td>
                                    <td><?php echo $respuesta['apellido_ma']; ?></td>
                                    <td><?php echo $respuesta['licenciatura']; ?></td>
                                    <td><?php echo $respuesta['pregunta']; ?></td>
                                    <td><?php echo $respuesta['opcion']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <!-- Paginación -->
                    <div class="pagination">
                        <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                            <a href="?pagina=<?php echo $i; ?>&alumno_id=<?php echo $alumno_id; ?>" class="<?php echo ($i == $pagina) ? 'active' : ''; ?>"><?php echo $i; ?></a>
                        <?php endfor; ?>
                    </div>

                <?php else: ?>
                    <p>No se encontraron respuestas para este alumno.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>
