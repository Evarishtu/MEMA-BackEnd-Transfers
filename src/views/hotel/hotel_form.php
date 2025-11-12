<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear nuevo hotel</title>
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

    <p><a href="/?url=hotel/listarHoteles">Volver al listado</a></p>
</body>
</html>
