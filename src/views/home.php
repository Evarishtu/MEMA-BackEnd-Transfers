<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Isla Transfers - Inicio</title>
  <style>
    body {
      margin: 0;
      font-family: "Arial", sans-serif;
      background: linear-gradient(135deg, #3a7bd5, #00d2ff);
      color: #fff;
    }

    /* Barra superior */
    .navbar {
      background: #ffffff;
      padding: 15px 40px;
      border-bottom-left-radius: 20px;
      border-bottom-right-radius: 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .navbar .left {
      font-size: 16px;
      color: #2c3e50;
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .navbar .right a {
      padding: 8px 16px;
      margin-left: 8px;
      background: #3274ff;
      color: #fff;
      border-radius: 8px;
      text-decoration: none;
      font-size: 14px;
      font-weight: bold;
      transition: 0.2s;
    }

    .navbar .right a:hover {
      background: #195dff;
    }

    /* Contenedor principal */
    .container {
      max-width: 1200px;
      margin: 50px auto;
      padding: 40px;
      background: rgba(0, 0, 0, 0.25);
      border-radius: 20px;
      display: flex;
      gap: 60px;
      align-items: center;
    }

    /* Columna izquierda */
    .left-column h1 {
      font-size: 42px;
      margin-bottom: 10px;
      font-weight: bold;
    }

    .left-column p {
      font-size: 18px;
      margin-bottom: 30px;
    }

    /* Tarjeta de formularios */
    .card {
      background: rgba(0, 0, 0, 0.30);
      padding: 25px;
      border-radius: 15px;
      width: 360px;
    }

    .card h2 {
      margin-top: 0;
      font-size: 22px;
    }

    .card ul {
      list-style: none;
      padding: 0;
      margin: 0;
      line-height: 1.8;
    }

    .card li a {
      color: #aee3ff;
      text-decoration: none;
      font-size: 15px;
    }

    .card li a:hover {
      text-decoration: underline;
    }

    /* Imagen del coche */
    .car-img {
      width: 50%;
      filter: drop-shadow(0px 10px 15px rgba(0,0,0,0.3));
    }

    @media (max-width: 900px) {
      .container {
        flex-direction: column;
        text-align: center;
      }
      .car-img {
        width: 280px;
      }
      .card {
        width: 100%;
      }
    }
  </style>
</head>

<body>

  <!-- NAVBAR -->
  <div class="navbar">
    <div class="left">
      <span>📍</span> <span>Gestión de zonas</span>
    </div>
    <div class="right">
      <a href="?url=login/login">Iniciar sesión</a>
      <a href="?url=registro/registrar">Registrarse</a>
    </div>
  </div>

  <!-- CONTENIDO PRINCIPAL -->
  <div class="container">

    <!-- Texto izquierda -->
    <div class="left-column">
      <h1>👋 Bienvenido a<br>Isla Transfers</h1>
      <p>Gestione traslados fácilmente con nuestro sistema.</p>

      <!-- Tarjeta de formularios -->
      <div class="card">
        <h2>📌 Formularios auxiliares<br><small>(Plantillas)</small></h2>
        <ul>
          <li><a href="?url=zona/index">Gestión de zonas</a></li>
          <li><a href="?url=zona/create">Crear nueva zona</a></li>
          <li><a href="?url=reservatipo/index">Gestión de tipos de reserva</a></li>
          <li><a href="?url=reservatipo/create">Crear nuevo tipo de reserva</a></li>
          <li><a href="?url=hotel/index">Gestión de hoteles</a></li>
          <li><a href="?url=hotel/listarZonas">Crear nuevo hotel</a></li>
          <li><a href="?url=vehiculo/listarvehiculos">Gestión de vehículos</a></li>
          <li><a href="?url=vehiculo/crearvehiculo">Crear nuevo vehículo</a></li>
        </ul>
      </div>
    </div>

    <!-- Imagen del coche -->
    <img src="furgoneta.png" class="car-img" alt="Car Image">
  </div>

</body>
</html>