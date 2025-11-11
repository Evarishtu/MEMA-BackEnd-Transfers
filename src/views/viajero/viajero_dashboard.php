<?php
/*
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Proteger acceso si no está logueado como viajero
if (empty($_SESSION['rol']) || $_SESSION['rol'] !== 'viajero') {
    header('Location: /?url=login/login');
    exit;
}
    */
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel del Viajero</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f7f7;
            color: #333;
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Bienvenido, <?= htmlspecialchars($_SESSION['user_nombre'] ?? 'Viajero') ?></h1>
        <ul>
            <li><a href="/?url=viajero/obtenerReservasPorViajero">📋 Mis reservas</a></li>
            <li><a href="/?url=viajero/crearReserva">✈️ Crear reserva</a></li>
            <li><a href="/?url=viajero/informacionPersonal">👤 Información personal</a></li>
        </ul>

        <div class="logout">
            <a href="/?url=login/logout">Cerrar sesión</a>
        </div>
    </div>
</body>
</html>

