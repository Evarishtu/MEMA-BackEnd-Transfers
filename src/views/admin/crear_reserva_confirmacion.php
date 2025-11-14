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
            <em><?= htmlspecialchars($email) ?></em>
        </div>

        <p><a href="/?url=admin/dashboard">← Volver al panel</a></p>
    </body>
</html>
