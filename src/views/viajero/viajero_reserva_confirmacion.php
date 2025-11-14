<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'viajero') {
    header('Location: /?url=login/login');
    exit;
}

$localizador = $localizador ?? '—';
$hotel_nombre = $hotel_nombre ?? '';
$tipo_reserva_texto = $tipo_reserva_texto ?? '';
$num_viajeros = $num_viajeros ?? '';
$email = $_SESSION['user_email'] ?? '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reserva confirmada</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f6f7;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 700px;
            margin: 60px auto;
            background: white;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #27ae60;
            text-align: center;
        }
        h2 {
            color: #444;
        }
        ul {
            background: #fafafa;
            padding: 15px 20px;
            border-radius: 8px;
            border-left: 4px solid #27ae60;
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
        .btn {
            display: inline-block;
            margin-top: 30px;
            background: #3498db;
            color: white;
            padding: 12px 22px;
            text-decoration: none;
            border-radius: 8px;
            font-size: 16px;
            transition: 0.2s;
        }
        .btn:hover {
            background: #2980b9;
        }
        .localizador-box {
            background: #fff7e6;
            border-left: 4px solid #f39c12;
            padding: 12px 18px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 18px;
        }
    </style>
</head>

<body>
    <div class="container">

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

        <a class="btn" href="/?url=viajero/dashboard">← Volver al panel</a>

    </div>
</body>
</html>
