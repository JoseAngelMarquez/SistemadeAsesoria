<?php
require_once(__DIR__ . "/../../controller/AsesoriaAlumnoController.php");

$controller = new AsesoriasController($conexion);
$data = $controller->mostrarHistorial();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/Proyecto_web/assets/css/esqueleto.css">
    <link rel="stylesheet" href="/Proyecto_web/assets/cssalumno/misasesorias.css">
    <title>Historial de Asesorías</title>
</head>
<body>
    <div class="container">
        <!-- Menú lateral izquierdo -->
        <nav class="sidebar">
            <ul>
                <li><a href="inicio.php"><i class="fas fa-home"></i> Inicio</a></li>
                <li><a href="Solicitar_asesoria.php"><i class="fas fa-chart-line"></i> Solicitar asesorías</a></li>
                <li><a href="misasesorias.php"><i class="fas fa-users"></i> Mis asesorías</a></li>
                <li><a href="encuesta.php"><i class="fas fa-cogs"></i> Encuesta</a></li>
                <li><a href="perfil.php"><i class="fas fa-question-circle"></i> Perfil</a></li>
            </ul>
            <div class="logout">
                <a href="#"><i class="fas fa-sign-out-alt"></i> Salir</a>
            </div>
        </nav>

        <!-- Contenido principal -->
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

            <!-- Tabla de historial -->
            <div class="content">
                <h1>Historial de Asesorías</h1>

                <!-- Tabla mejorada -->
                <table class="history-table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Tipo de Asesoría</th>
                            <th>Motivo</th>
                            <th>Maestro</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($data['historial']->num_rows > 0): ?>
                            <?php while ($row = $data['historial']->fetch_assoc()): ?>
                                <tr>
                                    <td>
                                        <i class="fas fa-calendar-alt" style="color: #3498db; margin-right: 8px;"></i>
                                        <?= htmlspecialchars($row['fecha_asesoria']) ?>
                                    </td>
                                    <td>
                                        <span class="<?= $row['tipo_asesoria'] === 'Individual' ? 'badge badge-individual' : 'badge badge-grupal' ?>">
                                            <?= htmlspecialchars($row['tipo_asesoria']) ?>
                                        </span>
                                    </td>
                                    <td><?= htmlspecialchars($row['motivo_asesoria']) ?></td>
                                    <td>
                                        <i class="fas fa-user-tie" style="color: #2c3e50; margin-right: 8px;"></i>
                                        <?= htmlspecialchars($row['maestro']) ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="no-records">No hay asesorías registradas</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <!-- Paginación -->
                <div class="pagination">
                    <?php if ($data['current_page'] > 1): ?>
                        <a href="?page=<?= $data['current_page'] - 1 ?>" class="prev">Anterior</a>
                    <?php endif; ?>
                    <?php if ($data['current_page'] < $data['total_pages']): ?>
                        <a href="?page=<?= $data['current_page'] + 1 ?>" class="next">Siguiente</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
