<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
  header('Location: /?url=login/login'); exit;
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
        margin: 40px;
        line-height: 1.6;
        }

        h1 {
        color: #007bff;
        margin-bottom: 20px;
        }

        h3 {
        margin-top: 25px;
        color: #333;
        }

        ul {
        margin-top: 10px;
        padding-left: 20px;
        }

        ul li {
        margin-bottom: 6px;
        }

        strong, b {
        color: #000;
        }

        a {
        color: #007bff;
        text-decoration: none;
        margin-right: 15px;
        }

        a:hover {
        text-decoration: underline;
        }

        .acciones {
        margin-top: 25px;
        }
    </style>
</head>
    <body>
        <h1>Reserva <?= htmlspecialchars($r['localizador'] ?? '') ?></h1>
        <ul>
            <li><b>Tipo: </b><?= htmlspecialchars($r['tipo_descripcion'] ?? '')?></li>
            <li><b>Hotel: </b><?= htmlspecialchars($r['hotel_nombre'] ?? '')?></li>
            <li><b>Cliente: </b><?= htmlspecialchars($r['email_cliente'] ?? '')?></li>
            <li><b>Fecha reserva: </b><?= htmlspecialchars($r['fecha_reserva'] ?? '')?></li>
            <li><b>Vehículo: </b><?= htmlspecialchars($r['vehiculo_descripcion'] ?? '')?></li>
            <li><b>Número viajeros: </b><?= htmlspecialchars($r['num_viajeros'] ?? '')?></li>
        </ul>
        <h3>Aeropuerto->Hotel</h3>
        <ul>
            <li><b>Fecha vuelo llegada: </b><?= htmlspecialchars($r['fecha_entrada'] ?? '')?></li>
            <li><b>Hora vuelo llegada: </b><?= htmlspecialchars($r['hora_entrada'] ?? '')?></li>
            <li><b>Número vuelo llegada: </b><?= htmlspecialchars($r['numero_vuelo_entrada'] ?? '')?></li>
            <li><b>Origen vuelo:</b><?= htmlspecialchars($r['origen_vuelo_entrada'] ?? '')?></li>
        </ul>
        <h3>Hotel->Aeropuerto</h3>
        <ul>
            <li><b>Fecha vuelo salida: </b><?= htmlspecialchars($r['fecha_vuelo_salida'] ?? '')?></li>
            <li><b>Hora vuelo salida: </b><?= htmlspecialchars($r['hora_vuelo_salida'] ?? '')?></li>
            <li><b>Número vuelo salida: </b><?= htmlspecialchars($r['numero_vuelo_salida'] ?? '')?></li>
            <li><b>Hora recogida en hotel: </b><?= htmlspecialchars($r['hora_recogida'] ?? '')?></li>
        </ul>
        <p>
            <a href="/?url=admin/editarReserva&id=<?= urlencode($r['id_reserva'] ?? '') ?>">Editar</a>
            <a href="/?url=admin/listarReservas">⬅️ Volver</a>
        </p>
    </body>
</html>