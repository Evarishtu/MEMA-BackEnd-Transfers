<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= isset($reservatipo) ? 'Editar tipo de reserva' : 'Crear tipo de reserva' ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        form { max-width: 500px; }
        label { font-weight: bold; }
        textarea {
            width: 100%;
            height: 80px;
            margin-top: 5px;
            margin-bottom: 15px;
            font-size: 14px;
        }
        button, a.btn {
            display: inline-block;
            padding: 8px 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
        }
        button:hover, a.btn:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            background-color: #ffe6e6;
            padding: 8px;
            border-radius: 4px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<p><a href="/" class="btn">🏠 Volver al inicio</a></p>

<h2><?= isset($reservatipo) ? '✏️ Editar tipo de reserva' : '➕ Crear tipo de reserva' ?></h2>

<?php if (!empty($error)): ?>
    <div class="error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="POST" 
      action="<?= isset($reservatipo) ? '/?url=reservatipo/edit&id=' . $reservatipo['id_tipo_reserva'] : '/?url=reservatipo/create' ?>">

    <label for="descripcion">Descripción:</label><br>
    <textarea name="descripcion" id="descripcion" required><?= isset($reservatipo) ? htmlspecialchars($reservatipo['descripcion']) : '' ?></textarea><br>

    <button type="submit">💾 Guardar</button>
    <a href="/?url=reservatipo/index" class="btn">⬅️ Volver</a>
</form>
</body>
</html>