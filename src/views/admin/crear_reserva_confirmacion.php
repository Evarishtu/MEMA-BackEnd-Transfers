<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
    header('Location: ?url=login/login');
    exit;
}

$localizador = $localizador ?? '—';
$email = $email ?? '';
$tipo_reserva_texto = $tipo_reserva_texto ?? '';
$hotel_nombre = $hotel_nombre ?? '';
$num_viajeros = $numero_viajeros ?? '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reserva confirmada</title>

    <style>
        body {
            margin: 0;
            padding: 60px 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #3a7bd5, #00d2ff);
            color: #fff;
            min-height: 100vh;
        }

        .card {
            width: 90%;
            max-width: 650px;
            margin: auto;
            background: rgba(255, 255, 255, 0.32);
            backdrop-filter: blur(10px);
            padding: 35px;
            border-radius: 16px;
            color: #003e60;
            box-shadow: 0 4px 12px rgba(0,0,0,0.20);
        }

        h1 {
            text-align: center;
            margin-top: 0;
            color: #eaffff;
        }

        .localizador-box {
            background: #fff7e6;
            border-left: 4px solid #f39c12;
            padding: 12px 18px;
            border-radius: 6px;
            margin: 20px 0;
            font-size: 18px;
        }

        h2 {
            color: #003e60;
            margin-top: 25px;
        }

        ul {
            background: rgba(255,255,255,0.35);
            padding: 15px 20px;
            border-radius: 8px;
            list-style: none;
        }

        ul li {
            margin-bottom: 8px;
            font-size: 16px;
        }

        .email-box {
            background: #eef7ff;
            border-left: 4px solid #3498db;
            padding: 12px 18px;
            border-radius: 6px;
            margin-top: 20px;
        }

        a {
            color: #003354;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        .volver {
            text-align: center;
            margin-top: 25px;
        }
    </style>
</head>

<body>

<div class="card">

    <h1>Reserva creada correctamente</h1>

    <div class="localizador-box">
        <strong>Localizador:</strong> <?= htmlspecialchars($localizador) ?>
    </div>

    <h2>Detalles de la reserva</h2>
    <ul>
        <li><strong>Tipo de trayecto:</strong> <?= htmlspecialchars($tipo_reserva_texto) ?></li>
        <li><strong>Hotel:</strong> <?= htmlspecialchars($hotel_nombre) ?></li>
        <li><strong>Número de viajeros:</strong> <?= htmlspecialchars($num_viajeros) ?></li>
    </ul>

    <div class="email-box">
        Se ha enviado un correo electrónico con los detalles de la reserva a:<br>
        <strong><?= htmlspecialchars($email) ?></strong>
    </div>

    <p class="volver"><a href="?url=admin/dashboard">← Volver al panel</a></p>

</div>

</body>
</html>