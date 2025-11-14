<?php 
if (session_status() === PHP_SESSION_NONE){
    session_start();
}

if(!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador'){
    header('Location: /?url=login/login');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f7f7;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 50px auto;
            background: #fff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        ul {
            list-style: none;
            padding: 0;
            text-align: center;
        }

        li {
            margin: 20px 0;
        }

        a {
            text-decoration: none;
            color: #0066cc;
            font-size: 18px;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        .logout {
            text-align: center;
            margin-top: 40px;
        }

        .logout a {
            color: #d00000;
        }

        .logout a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Panel de Administración — Bienvenido, <?= htmlspecialchars($_SESSION['user_nombre']) ?></h1>

        <ul>
            <li><a href="/?url=admin/calendario">📅 Calendario de reservas</a></li>
            <li><a href="/?url=admin/crearReserva">🆕 Crear nueva reserva</a></li>
            <li><a href="/?url=admin/listarReservas">📋 Consultar y gestionar reservas</a></li>
            <li><a href="/?url=admin/informacionPersonal">👥 Información personal</a></li>
        </ul>

        <div class="logout">
            <a href="/?url=login/logout">🚪 Cerrar sesión</a>
        </div>
    </div>

</body>
</html>
