<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Crear nuevo hotel</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <style>
    body {
      margin: 0;
      font-family: "Arial", sans-serif;
      background: linear-gradient(135deg, #3a7bd5, #00d2ff);
      color: #fff;
    }

    .navbar {
      background: #ffffff;
      padding: 15px 40px;
      border-bottom-left-radius: 20px;
      border-bottom-right-radius: 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .navbar .left a {
      color: #2c3e50;
      text-decoration: none;
      font-size: 16px;
      font-weight: bold;
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .navbar .right a {
      padding: 8px 16px;
      background: #3274ff;
      color: #fff;
      border-radius: 8px;
      text-decoration: none;
      font-size: 14px;
      font-weight: bold;
      transition: 0.2s;
      margin-left: 8px;
    }

    .navbar .right a:hover {
      background: #195dff;
    }

    .container {
      max-width: 800px;
      margin: 50px auto;
      background: rgba(0,0,0,0.25);
      border-radius: 20px;
      padding: 40px;
    }

    h2 {
      margin-top: 0;
      font-size: 30px;
    }

    form {
      margin-top: 20px;
    }

    label {
      font-weight: bold;
      font-size: 15px;
    }

    input, select {
      width: 100%;
      padding: 12px;
      border-radius: 10px;
      border: none;
      margin-top: 8px;
      margin-bottom: 20px;
      font-size: 15px;
    }

    .btn, button {
      display: inline-block;
      padding: 10px 18px;
      background: #3274ff;
      color: white;
      border: none;
      border-radius: 8px;
      text-decoration: none;
      cursor: pointer;
      font-weight: bold;
      transition: 0.2s;
      margin-right: 10px;
    }

    .btn:hover, button:hover {
      background: #195dff;
    }
  </style>

</head>
<body>

  <div class="navbar">
    <div class="left">
      <a href="./"><span>🏠</span> Volver al inicio</a>
    </div>
    <div class="right">
      <a href="?url=login/login">Iniciar sesión</a>
      <a href="?url=registro/registrar">Registrarse</a>
    </div>
  </div>

  <div class="container">

    <h2>🏨 Crear nuevo hotel</h2>

    <form method="POST" action="?url=hotel/crearHotel">

      <label for="nombre">Nombre del hotel:</label>
      <input type="text" name="nombre" required>

      <label for="id_zona">Zona:</label>
      <select name="id_zona" required>
        <option value="">-- Selecciona una zona --</option>
        <?php foreach ($zonas as $zona): ?>
          <option value="<?= htmlspecialchars($zona['id_zona']) ?>">
            <?= htmlspecialchars($zona['descripcion']) ?>
          </option>
        <?php endforeach; ?>
      </select>

      <label for="comision">Comisión (%):</label>
      <input type="number" name="comision">

      <label for="usuario">Usuario:</label>
      <input type="text" name="usuario">

      <label for="password">Contraseña:</label>
      <input type="password" name="password">

      <button type="submit">Guardar hotel</button>
      <a href="?url=hotel/listarHoteles" class="btn">⬅️ Volver al listado</a>

    </form>

  </div>

</body>
</html>