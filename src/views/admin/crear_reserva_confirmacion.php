<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
    header('Location: /?url=login/login');
    exit;
}

$localizador = $localizador ?? '—';
$email = $email ?? '';
$tipo_reserva_texto = $tipo_reserva_texto ?? '';
$hotel_nombre = $hotel_nombre ?? '';
$num_viajeros = $num_viajeros ?? '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reserva confirmada</title>
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

    h2 {
      margin-top: 25px;
      color: #333;
    }

    ul {
      margin-top: 10px;
      padding-left: 20px;
    }

    li {
      margin-bottom: 6px;
    }

    strong {
      color: #000;
    }

    em {
      color: #555;
    }

    a {
      color: #007bff;
      text-decoration: none;
      margin-top: 20px;
      display: inline-block;
    }

    a:hover {
      text-decoration: underline;
    }
  </style>
</head>
    <body>
        <h1>Reserva creada correctamente</h1>

        <p><strong>Localizador:</strong> <?= htmlspecialchars($localizador) ?></p>
        <h2>Detalles de la reserva</h2>
        <ul>
            <li><strong>Tipo de trayecto:</strong> <?= htmlspecialchars($tipo_reserva_texto) ?></li>
            <li><strong>Hotel:</strong> <?= htmlspecialchars($hotel_nombre) ?></li>
            <li><strong>Número de viajeros:</strong> <?= htmlspecialchars($num_viajeros) ?></li>
        </ul>

        <p>Se ha enviado un correo electrónico con los detalles de la reserva a:</p>
        <p><em><?= htmlspecialchars($email) ?></em></p>

        <p><a href="/?url=admin/dashboard">⬅️ Volver al panel</a></p>
    </body>
</html>