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
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #3a7bd5, #00d2ff);
            padding-top: 120px;
            padding-bottom: 60px;
            color: #fff;
            min-height: 100vh;
        }

        .card {
            width: 92%;
            max-width: 750px;
            margin: auto;
            background: rgba(255, 255, 255, 0.30);
            backdrop-filter: blur(10px);
            padding: 35px;
            border-radius: 18px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            text-align: center;
        }

        h1 {
            margin-top: 0;
            margin-bottom: 30px;
            font-size: 30px;
            color: #e7ffe7;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        ul li {
            background: rgba(255, 255, 255, 0.45);
            padding: 14px;
            margin: 12px 0;
            border-radius: 10px;
            border-left: 4px solid #004a80;
            transition: 0.2s;
        }

        ul li:hover {
            background: rgba(255, 255, 255, 0.60);
        }

        a {
            text-decoration: none;
            color: #003b63;
            font-weight: bold;
            font-size: 17px;
        }

        .logout {
            margin-top: 35px;
        }

        .logout a {
            background: #004a80;
            color: white;
            padding: 10px 18px;
            border-radius: 10px;
            font-size: 16px;
            display: inline-block;
            transition: 0.2s;
        }

        .logout a:hover {
            background: #00345a;
        }

    </style>
</head>
<body>

    <div class="card">

        <!-- ====================== -->
        <!-- TÍTULO DEL PANEL -->
        <!-- ====================== -->
        <h1>Panel de Administración — Bienvenido, <?= htmlspecialchars($_SESSION['user_nombre']) ?></h1>

        <!-- ====================== -->
        <!-- OPCIONES PRINCIPALES -->
        <!-- ====================== -->
        <ul>
            <li><a href="/?url=admin/calendario">📅 Calendario de reservas</a></li>
            <li><a href="/?url=admin/crearReserva">🆕 Crear nueva reserva</a></li>
            <li><a href="/?url=admin/listarReservas">📋 Consultar y gestionar reservas</a></li>
            <li><a href="/?url=admin/informacionPersonal">👥 Información personal</a></li>
        </ul>

        <!-- ====================== -->
        <!-- BOTÓN DE SALIR -->
        <!-- ====================== -->
        <div class="logout">
            <a href="/?url=login/logout">🚪 Cerrar sesión</a>
        </div>

    </div>

</body>
</html>