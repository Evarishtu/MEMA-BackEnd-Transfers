<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
  header('Location: ?url=login/login'); exit;
}

$r = $reserva ?? [];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de reserva</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 60px 0;
            background: linear-gradient(135deg, #3a7bd5, #00d2ff);
            min-height: 100vh;
            color: #fff;
        }

        .card {
            width: 90%;
            max-width: 750px;
            margin: auto;
            background: rgba(255,255,255,0.35);
            backdrop-filter: blur(10px);
            padding: 35px;
            border-radius: 16px;
            color: #003e60;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }

        h1 {
            text-align: center;
            color: #eaffff;
        }

        h3 {
            margin-top: 25px;
            color: #003e60;
        }

        ul {
            margin-top: 10px;
            padding-left: 20px;
        }

        ul li {
            margin-bottom: 6px;
            font-size: 15px;
        }

        strong, b {
            color: #002b40;
        }

        a {
            color: #004b73;
            text-decoration: none;
            font-weight: bold;
            margin-right: 15px;
        }

        a:hover {
            text-decoration: underline;
        }

        .acciones {
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>

<body>

<div class="card">

    <h1>Reserva <?= htmlspecialchars($r['localizador'] ?? '') ?></h1>

    <ul>
        <li><b>Tipo:</b> <?= htmlspecialchars($r['tipo_descripcion'] ?? '') ?></li>
        <li><b>Hotel:</b> <?= htmlspecialchars($r['hotel_nombre'] ?? '') ?></li>
        <li><b>Cliente:</b> <?= htmlspecialchars($r['email_cliente'] ?? '') ?></li>
        <li><b>Fecha de creación:</b> <?= htmlspecialchars($r['fecha_reserva'] ?? '') ?></li>
        <li><b>Vehículo asignado:</b> <?= htmlspecialchars($r['vehiculo_descripcion'] ?? '') ?></li>
        <li><b>Número de viajeros:</b> <?= htmlspecialchars($r['num_viajeros'] ?? '') ?></li>
    </ul>

    <h3>Aeropuerto → Hotel</h3>
    <ul>
        <li><b>Fecha vuelo llegada:</b> <?= htmlspecialchars($r['fecha_entrada'] ?? '') ?></li>
        <li><b>Hora vuelo llegada:</b> <?= htmlspecialchars($r['hora_entrada'] ?? '') ?></li>
        <li><b>Número vuelo llegada:</b> <?= htmlspecialchars($r['numero_vuelo_entrada'] ?? '') ?></li>
        <li><b>Origen vuelo:</b> <?= htmlspecialchars($r['origen_vuelo_entrada'] ?? '') ?></li>
    </ul>

    <h3>Hotel → Aeropuerto</h3>
    <ul>
        <li><b>Fecha vuelo salida:</b> <?= htmlspecialchars($r['fecha_vuelo_salida'] ?? '') ?></li>
        <li><b>Hora vuelo salida:</b> <?= htmlspecialchars($r['hora_vuelo_salida'] ?? '') ?></li>
        <li><b>Número vuelo salida:</b> <?= htmlspecialchars($r['numero_vuelo_salida'] ?? '') ?></li>
        <li><b>Hora recogida en hotel:</b> <?= htmlspecialchars($r['hora_recogida'] ?? '') ?></li>
    </ul>

    <div class="acciones">
        <a href="?url=admin/editarReserva&id=<?= urlencode($r['id_reserva'] ?? '') ?>">✏️ Editar</a>
        <a href="?url=admin/listarReservas">⬅️ Volver</a>
    </div>

</div>

</body>
</html>