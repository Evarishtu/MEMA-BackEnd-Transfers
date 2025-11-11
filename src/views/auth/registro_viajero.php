<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Cliente Particular</title>
</head>
    <body>
        <h2>Registro de Cliente Particular</h2>
        <form method = "POST" action = "/?url=registro/registrar">
            <input type = "hidden" name = "rol" value ="viajero">

            <label for = "email">Email de autenticación de usuario:</label><br>
            <input type = "email" name = "email" placeholder = "tu email" required><br><br>

            <label for = "password">Contraseña de usuario:</label><br>
            <input type = "password" name = "password" placeholder = "contraseña de usuario" required><br><br>

            <label for = "nombre_cliente">Nombre:</label><br>
            <input type = "text" name = "nombre" placeholder ="tu nombre" required><br><br>

            <label for = "apellido1">Primer apellido:</label><br>
            <input type = "text" name = "apellido1" placeholder ="tu primer apellido" required><br><br>

            <label for = "apellido2">Segundo apellido:</label><br>
            <input type = "text" name = "apellido2" placeholder ="tu segundo apellido" required><br><br>

            <label for = "direccion">Dirección:</label><br>
            <input type = "text" name = "direccion" placeholder ="tu dirección" required><br><br>

            <label for = "codigo_postal">Código postal:</label><br>
            <input type = "text" name = "codigoPostal" placeholder ="tu código postal" required><br><br>

            <label for = "pais">País:</label><br>
            <input type = "text" name = "pais" placeholder ="tu país" required><br><br>

            <label for = "ciudad">Ciudad:</label><br>
            <input type = "text" name = "ciudad" placeholder ="tu ciudad" required><br><br>

            <button type = "submit">Registrar</button>
        </form>
        <p><a href="/?url=registro/registrar"><- Volver al inicio del registro</a></p>
    </body>
</html>