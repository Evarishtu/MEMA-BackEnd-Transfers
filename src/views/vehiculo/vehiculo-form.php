<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= isset($vehiculo) ? 'Editar vehículo' : 'Crear nuevo vehículo' ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f9f9f9;
        }
        h2 {
            margin-bottom: 20px;
        }
        form {
            background: #fff;
            padding: 20px;
            border-radius: 6px;
            box-shadow: 0 0 4px rgba(0,0,0,0.1);
            max-width: 400px;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input {
            width: 100%;
            padding: 6px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            margin-top: 15px;
            padding: 8px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        p a {
            display: inline-block;
            margin-top: 15px;
            color: #007bff;
            text-decoration: none;
        }
        p a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <p><a href="/" class="btn">🏠 Volver al inicio</a></p>

    <h2><?= isset($vehiculo) ? '✏️ Editar vehículo' : '🚗 Crear nuevo vehículo' ?></h2>

    <form method="POST" action="/?url=vehiculo/<?= isset($vehiculo) ? 'actualizarvehiculo' : 'guardarvehiculo' ?>">
        <?php if (isset($vehiculo)): ?>
            <input type="hidden" name="id" value="<?= htmlspecialchars($vehiculo['id_vehiculo']) ?>">
        <?php endif; ?>

        <label for="descripcion">Descripción del vehículo:</label>
        <input type="text" id="descripcion" name="descripcion" value="<?= htmlspecialchars($vehiculo['descripcion'] ?? '') ?>" required>

        <?php if (!isset($vehiculo)): ?>
            <label for="email_conductor">Email del conductor:</label>
            <input type="email" id="email_conductor" name="email_conductor">

            <label for="password_conductor">Contraseña del conductor:</label>
            <input type="password" id="password_conductor" name="password_conductor">
        <?php endif; ?>

        <button type="submit"><?= isset($vehiculo) ? 'Actualizar vehículo' : 'Guardar vehículo' ?></button>
    </form>

    <p><a href="/?url=vehiculo/listarvehiculos">⬅️ Volver al listado</a></p>

</body>
</html>
