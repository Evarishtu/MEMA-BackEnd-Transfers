<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de cliente corporativo</title>
</head>
<body>
    <header>
        <h1>Registro de cliente corporativo (Hotel)</h1>
    </header>
    <main>
        <form method = "POST" action = "/?url=registro/guardarHotel">
            <input type = "hidden" name = "rol" value = "hotel">
            
            <label>Nombre del hotel:</label><br>
            <input type = "text" name = "nombre_hotel" id = "nombre_hotel" required><br><br>
            
            <label for = "id_zona">Zona:</label><br>
            <select id = "id_zona" name = "id_zona">
                <option value = "">--Seleccionar zona--</option>
                <?php if (!empty($zonas)): ?>
                    <?php foreach ($zonas as $zona): ?>
                        <option value = "<?= htmlspecialchars($zona['id_zona']) ?>">
                            <?= htmlspecialchars($zona['nombre_zona'])?>   
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>           
            </select><br><br>
            <label for = "comision">Comission (%)</label><br>
            <input type = "text" id = "comision" name = "comision" required><br><br>

            <label for = "password">Contraseña:</label><br>
            <input type = "password" id = "password" name = "password" required><br><br>

            <button type = "submit">Registrar></button> 
        </form>
    </main>
</body>
</html>