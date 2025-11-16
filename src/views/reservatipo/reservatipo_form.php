<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title><?= isset($reservatipo) ? 'Editar tipo de reserva' : 'Crear tipo de reserva' ?></title>
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

    textarea {
      width: 100%;
      height: 100px;
      margin-top: 8px;
      margin-bottom: 20px;
      border-radius: 10px;
      border: none;
      padding: 12px;
      font-size: 15px;
      resize: vertical;
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

    .error {
      background: rgba(255, 0, 0, 0.3);
      color: #ffdddd;
      padding: 10px;
      border-radius: 8px;
      margin-bottom: 20px;
      font-weight: bold;
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

    <h2><?= isset($reservatipo) ? '✏️ Editar tipo de reserva' : '➕ Crear tipo de reserva' ?></h2>

    <?php if (!empty($error)): ?>
      <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" 
          action="<?= isset($reservatipo) ? '?url=reservatipo/edit&id=' . $reservatipo['id_tipo_reserva'] : '/?url=reservatipo/create' ?>">

      <label for="descripcion">Descripción:</label><br>
      <textarea name="descripcion" id="descripcion" required><?= isset($reservatipo) ? htmlspecialchars($reservatipo['descripcion']) : '' ?></textarea>

      <button type="submit">💾 Guardar</button>
      <a href="?url=reservatipo/index" class="btn">⬅️ Volver</a>
    </form>

  </div>

</body>
</html>