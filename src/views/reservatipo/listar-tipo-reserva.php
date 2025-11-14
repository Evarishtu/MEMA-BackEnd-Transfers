<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Gestión de tipo de reservas</title>
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
      display: flex;
      align-items: center;
      font-weight: bold;
      gap: 6px;
    }

    .navbar .right a {
      padding: 8px 16px;
      margin-left: 10px;
      background: #3274ff;
      color: white;
      border-radius: 8px;
      text-decoration: none;
      font-weight: bold;
      transition: 0.2s;
    }

    .navbar .right a:hover {
      background: #195dff;
    }

    .container {
      max-width: 1200px;
      margin: 40px auto;
      padding: 40px;
      background: rgba(0, 0, 0, 0.25);
      border-radius: 20px;
    }

    h2 {
      margin-top: 0;
      font-size: 32px;
    }

    .btn {
      display: inline-block;
      padding: 10px 18px;
      background: #3274ff;
      color: white;
      border-radius: 8px;
      text-decoration: none;
      font-weight: bold;
      transition: 0.2s;
    }

    .btn:hover {
      background: #195dff;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 10px;
      overflow: hidden;
    }

    th {
      background: rgba(255, 255, 255, 0.2);
      padding: 12px;
      text-align: left;
    }

    td {
      padding: 12px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }

    .acciones a {
      color: #aee3ff;
      text-decoration: none;
      font-weight: bold;
      margin-right: 12px;
    }

    .acciones a:hover {
      text-decoration: underline;
    }

  </style>
</head>
<body>

  <div class="navbar">
    <div class="left">
      <a href="/"><span>🏠</span> Volver al inicio</a>
    </div>
    <div class="right">
      <a href="/?url=login/login">Iniciar sesión</a>
      <a href="/?url=registro/registrar">Registrarse</a>
    </div>
  </div>

  <div class="container">

    <h2>📍 Gestión de tipo de reservas</h2>

    <a href="/?url=reservatipo/create" class="btn">➕ Nuevo tipo de reserva</a>

    <?php if (empty($reservatipo)): ?>
      <p style="margin-top:20px;">Todavía no hay tipo de reservas registrado.</p>

    <?php else: ?>
      <table>
        <thead>
          <tr>
            <th>ID tipo de reserva</th>
            <th>Descripción</th>
            <th>Acciones</th>
          </tr>
        </thead>

        <tbody>
          <?php foreach ($reservatipo as $r): ?>
            <tr>
              <td><?= htmlspecialchars($r['id_tipo_reserva']) ?></td>
              <td><?= htmlspecialchars($r['descripcion']) ?></td>
              <td class="acciones">
                <a href="/?url=reservatipo/edit&id=<?= $r['id_tipo_reserva'] ?>">✏️ Editar</a>
                <a href="/?url=reservatipo/delete&id=<?= $r['id_tipo_reserva'] ?>"
                   onclick="return confirm('¿Seguro que quieres eliminar este tipo de reserva?');">🗑️ Eliminar</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>

  </div>

</body>
</html>