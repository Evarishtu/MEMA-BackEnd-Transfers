<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['rol']) || $_SESSION['rol'] !== 'viajero') {
    header('Location: ?url=login/login');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel del Viajero</title>

  <style>
    body {
      margin: 0;
      font-family: "Arial", sans-serif;
      background: linear-gradient(135deg, #3a7bd5, #00d2ff);
      color: #fff;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      padding-top: 100px;
      min-height: 100vh;
    }

    .navbar {
      background: #ffffff;
      padding: 15px 40px;
      border-bottom-left-radius: 20px;
      border-bottom-right-radius: 20px;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    .navbar-title {
      font-size: 18px;
      font-weight: bold;
      color: #1f2937;
    }

    .navbar a.logout-btn {
      background: #ff4d4d;
      padding: 8px 14px;
      border-radius: 10px;
      color: #fff;
      font-weight: bold;
      text-decoration: none;
      transition: 0.3s;
    }

    .navbar a.logout-btn:hover {
      background: #e60000;
    }

    .container {
      background: rgba(0, 0, 0, 0.25);
      padding: 40px;
      border-radius: 20px;
      width: 450px;
      backdrop-filter: blur(6px);
      text-align: center;
    }

    h1 {
      margin-top: 0;
      margin-bottom: 25px;
      font-size: 30px;
      font-weight: bold;
    }

    .menu a {
      display: block;
      background: #ffffff33;
      padding: 14px;
      border-radius: 12px;
      margin: 12px 0;
      color: #e8f6ff;
      font-size: 18px;
      font-weight: bold;
      text-decoration: none;
      transition: 0.25s;
      backdrop-filter: blur(4px);
    }

    .menu a:hover {
      background: #ffffff55;
    }

  </style>
</head>

<body>

  <div class="navbar">
    <div class="navbar-title">Panel del Viajero</div>
    <a href="?url=login/logout" class="logout-btn">Cerrar sesión</a>
  </div>

  <div class="container">
    <h1>Hola, <?= htmlspecialchars($_SESSION['user_nombre'] ?? 'Viajero') ?> 👋</h1>

    <div class="menu">
      <a href="?url=viajero/obtenerReservasPorViajero">📋 Mis reservas</a>
      <a href="?url=viajero/crearReserva">✈️ Crear reserva</a>
      <a href="?url=viajero/informacionPersonal">👤 Información personal</a>
    </div>
  </div>

</body>
</html>