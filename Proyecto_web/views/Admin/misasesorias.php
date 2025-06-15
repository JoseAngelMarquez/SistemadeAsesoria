<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/Proyecto_web/assets/css/seccion2.css">
    <link rel="stylesheet" href="/Proyecto_web/assets/css/esqueleto.css">

    <link rel="stylesheet" href="http://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Asesoría</title>
</head>

<body>
    <div class="container">
        <nav class="sidebar">
            <ul>
            <li><a href="inicio.php"><i class="fas fa-home"></i> Inicio</a></li>
                <li><a href="Solicitar_asesoria.php"><i class="fas fa-chart-line"></i> Solicitar asesorias</a></li>
                <li><a href="misasesorias.php"><i class="fas fa-users"></i> Mis asesorías</a></li>
                <li><a href="encuesta.php"><i class="fas fa-cogs"></i> Encuesta</a></li>
                <li><a href="perfil.php"><i class="fas fa-question-circle"></i> Perfil</a></li>         </ul>
            <div class="logout">
                <a href="#"><i class="fas fa-sign-out-alt"></i> Salir</a>
            </div>
        </nav>

        <div class="main-content">
            <div class="top-bar">
                <div class="logo-section">
                    <i class="fas fa-laptop-code"></i>
                    <span class="software-name">UNSIS BOOST</span>
                </div>
                <div class="user-section">
                    <i class="fas fa-user-circle avatar"></i>
                    <button class="user-button">Perfil</button>
                </div>
            </div>

            <div class="container mt-5">
                <h1>Historial de asesorías</h1>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>adad</th>
                            <th>dsadsa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $server
                        ?>
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
</body>

</html>
