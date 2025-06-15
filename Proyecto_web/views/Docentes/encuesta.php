<?php require_once(__DIR__ . '/../../controller/EncuestaDocenteController.php'); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encuesta del Alumno</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/Proyecto_web/assets/css/esqueleto.css">
    <link rel="stylesheet" href="/Proyecto_web/assets/cssdocente/encuesta.css">
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
                <a href="#"><i class="fas fa-sign-out-alt"></i> Salir</a>
            </div>
        </nav>

        <div class="main-content">
            <div class="content">
                <h1>Encuesta</h1>

                <?php foreach ($alertas as $alerta): ?>
                    <div class="alert alert-<?= $alerta['tipo']; ?>">
                        <?= $alerta['mensaje']; ?>
                    </div>
                <?php endforeach; ?>

                <form method="POST">
                    <label>Pregunta:</label>
                    <input type="text" name="pregunta" required>
                    <label>Opciones:</label>
                    <input type="text" name="opciones[]" placeholder="Opción 1" required>
                    <input type="text" name="opciones[]" placeholder="Opción 2" required>
                    <input type="text" name="opciones[]" placeholder="Opción 3">
                    <input type="text" name="opciones[]" placeholder="Opción 4">
                    <button type="submit">Guardar Pregunta</button>
                </form>

                <h2>Preguntas Existentes</h2>
                <ul>
                    <?php foreach ($preguntas as $pregunta): ?>
                        <li>
                            <?= $pregunta['pregunta']; ?>
                            <form method="POST">
                                <input type="hidden" name="id_pregunta" value="<?= $pregunta['id']; ?>">
                                <select name="alumno_matricula">
                                    <?php foreach ($alumnos as $alumno): ?>
                                        <option value="<?= $alumno['matricula']; ?>"><?= $alumno['nombre']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="submit" name="asignar_pregunta">Asignar</button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
