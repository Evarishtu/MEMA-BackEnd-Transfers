<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear nuevo hotel</title>
    <style>
        body {
        font-family: Arial, sans-serif;
        margin: 40px;
        line-height: 1.6;
        }

        h2 {
        color: #007bff;
        margin-bottom: 20px;
        }

        .btn {
        display: inline-block;
        padding: 8px 14px;
        background-color: #007bff;
        color: white;
        text-decoration: none;
        border-radius: 4px;
        font-size: 14px;
        }

        .btn:hover {
        background-color: #0056b3;
        }

        table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        min-width: 600px;
        background: white;
        border: 1px solid #ddd;
        }

        th, td {
        padding: 10px;
        border-bottom: 1px solid #ddd;
        text-align: left;
        }

        th {
        background: #f3f3f3;
        }

        tr:nth-child(even) {
        background: #fafafa;
        }

        tr:hover {
        background: #f0f8ff;
        }

        .acciones a {
        margin-right: 12px;
        color: #007bff;
        text-decoration: none;
        }

        .acciones a:hover {
        text-decoration: underline;
        }
    </style>
</head>
<body>
    <h2>🏨 Crear nuevo hotel</h2>

    <form method="POST" action="/?url=hotel/crearHotel">
        <label for="nombre">Nombre del hotel:</label><br>
        <input type="text" name="nombre" required><br><br>

        <label for="id_zona">Zona:</label><br>
        <select name="id_zona" required>
            <option value="">-- Selecciona una zona --</option>
            <?php foreach ($zonas as $zona): ?>
                <option value="<?= htmlspecialchars($zona['id_zona']) ?>">
                    <?= htmlspecialchars($zona['descripcion']) ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="comision">Comisión (%):</label><br>
        <input type="number" name="comision"><br><br>

        <label for="usuario">Usuario:</label><br>
        <input type="text" name="usuario"><br><br>

        <label for="password">Contraseña:</label><br>
        <input type="password" name="password"><br><br>

        <button type="submit">Guardar hotel</button>
    </form>

    <p><a href="/?url=hotel/listarHoteles">⬅️ Volver al listado</a></p>
</body>
</html>
