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
