<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro Cliente Corporativo (Hotel)</title>

  <style>
    body {
      margin: 0;
      font-family: "Arial", sans-serif;
      background: linear-gradient(135deg, #3a7bd5, #00d2ff);
      color: #fff;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      padding-top: 80px;
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
    }

    .navbar a {
      color: #2c3e50;
      text-decoration: none;
      font-weight: bold;
      font-size: 16px;
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .container {
      background: rgba(0, 0, 0, 0.25);
      padding: 40px;
      border-radius: 20px;
      width: 420px;
      backdrop-filter: blur(4px);
    }

    h2 {
      margin-top: 0;
      margin-bottom: 25px;
      font-size: 28px;
    }

    label {
      font-weight: bold;
      margin-top: 12px;
      display: block;
    }

    input {
      width: 100%;
      padding: 12px;
      border-radius: 10px;
      border: none;
      margin-top: 6px;
      margin-bottom: 18px;
      font-size: 15px;
    }

    button {
      width: 100%;
      padding: 12px;
      background: #3274ff;
      border: none;
      border-radius: 10px;
      color: #fff;
      font-size: 16px;
      cursor: pointer;
      font-weight: bold;
      margin-top: 10px;
    }

    button:hover {
      background: #195dff;
    }

    .back {
      display: block;
      text-align: center;
      margin-top: 15px;
      color: #aee3ff;
      text-decoration: none;
      font-weight: bold;
    }

    .back:hover {
      text-decoration: underline;
    }
  </style>
</head>

<body>

  <div class="navbar">
    <a href="?url=registro/registrar">⬅️ Volver al inicio del registro</a>
  </div>

  <div class="container">
    <h2>🏨 Registro Cliente Corporativo</h2>

    <form method="POST" action="?url=registro/registrar">
      <input type="hidden" name="rol" value="hotel">

      <label>Nombre del hotel:</label>
      <input type="text" name="nombre" placeholder="Nombre del hotel" required>

      <label>ID de zona (opcional):</label>
      <input type="number" name="id_zona" placeholder="ID zona">

      <label>Comisión (%):</label>
      <input type="number" name="comision" placeholder="Ej. 10" min="0" max="100">

      <label>Usuario de acceso (número interno):</label>
      <input type="number" name="usuario" placeholder="Ej. 1234" required>

      <label>Contraseña:</label>
      <input type="password" name="password" placeholder="Contraseña segura" required>

      <button type="submit">Registrar</button>
    </form>

    <a href="?url=registro/registrar" class="back">⬅️ Volver al inicio</a>
  </div>

</body>
</html>