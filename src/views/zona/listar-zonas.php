<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Gestión de Zonas</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

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

    .navbar .left a {
      color: #2c3e50;
      text-decoration: none;
      font-size: 16px;
      display: flex;
      align-items: center;
      gap: 6px;
      font-weight: bold;
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
      margin: 40px auto;
      padding: 40px;
      background: rgba(0, 0, 0, 0.25);
      border-radius: 20px;
    }

    h2 {
      margin-top: 0;
      font-size: 32px;
      margin-bottom: 20px;
    }

    /* Botón */
    .btn {
      display: inline-block;
      padding: 10px 18px;
      background: #3274ff;
      color: white;
      text-decoration: none;
      border-radius: 8px;
      font-weight: bold;
      transition: 0.2s;
    }

    .btn:hover {
      background: #195dff;
    }

    /* Tabla */
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
      font-size: 15px;
    }

    td {
      padding: 12px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.15);
    }

    tr:last-child td {
      border-bottom: none;
    }

    .acciones a {
      margin-right: 12px;
      color: #aee3ff;
      text-decoration: none;
      font-weight: bold;
      transition: 0.2s;
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

    <h2>📍 Gestión de Zonas</h2>

    <a href="/?url=zona/create" class="btn">➕ Nueva Zona</a>

    <?php if (empty($zonas)): ?>
      <p style="margin-top:20px;">No hay zonas registradas todavía.</p>

    <?php else: ?>
      <table>
        <thead>
          <tr>
            <th>ID Zona</th>
            <th>Descripción</th>
            <th>Acciones</th>
          </tr>
        </thead>

        <tbody>
          <?php foreach ($zonas as $zona): ?>
            <tr>
              <td><?= htmlspecialchars($zona['id_zona']) ?></td>
              <td><?= htmlspecialchars($zona['descripcion']) ?></td>
              <td class="acciones">
                <a href="/?url=zona/edit&id=<?= $zona['id_zona'] ?>">✏️ Editar</a>
                <a href="/?url=zona/delete&id=<?= $zona['id_zona'] ?>"
                   onclick="return confirm('¿Seguro que quieres eliminar esta zona?');">🗑️ Eliminar</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>

  </div>

</body>
</html>