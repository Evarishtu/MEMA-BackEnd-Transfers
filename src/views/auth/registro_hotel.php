<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Cliente Corporativo (Hotel)</title>
</head>
    <body>
        <h2>Registro de Cliente Corporativo (Hotel)</h2>

        <form method="POST" action="/?url=registro/registrar">
            <input type="hidden" name="rol" value="hotel">

            <label for="nombre_hotel">Nombre del hotel:</label><br>
            <input type="text" id="nombre_hotel" name="nombre" placeholder="Nombre del hotel" required><br><br>

            <label for="id_zona">Zona (opcional):</label><br>
            <input type="number" id="id_zona" name="id_zona" placeholder="ID de zona (si aplica)"><br><br>

            <label for="comision">Comisión (%):</label><br>
            <input type="number" id="comision" name="comision" placeholder="Comisión (ej. 10)" min="0" max="100"><br><br>

            <label for="usuario">Usuario de acceso (número interno):</label><br>
            <input type="number" id="usuario" name="usuario" placeholder="Ej. 1234" required><br><br>

            <label for="password">Contraseña:</label><br>
            <input type="password" id="password" name="password" placeholder="Contraseña segura" required><br><br>

            <button type="submit">Registrar</button>
        </form>

        <p><a href="/?url=registro/registrar"><- Volver al inicio del registro</a></p>
    </body>
</html>