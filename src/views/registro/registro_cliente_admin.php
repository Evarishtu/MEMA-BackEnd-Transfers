<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Viajero</title>
</head>
    <body>
        <header>
            <h1>Registro de <?= htmlspecialchars($rol === 'usuario_admin' ? 'Administrador' : 'Cliente Particular')?></h1>
        </header>
        <main>
            <h2>Registro de Cliente Particular</h2>
            <form method = "POST" action = "/?url=registro/guardarUsuario">
                <input type = "hidden" name = "rol" value ="viajero">

                <label for = "nombre">Nombre:</label><br>
                <input type = "text" name = "nombre" id = "nombre" placeholder = "nombre" required><br><br>

                <label for = "apellido1">Primer apellido:</label><br>
                <input type = "text" name = "apellido1" id = "apellido1" placeholder = "primer apellido" required><br><br>

                <label for = "apellido2">Segundo apellido:</label><br>
                <input type = "text" name = "apellido2" id = "apellido2" placeholder ="segundo apellido" required><br><br>

                <label for = "direccion">Dirección:</label><br>
                <input type = "text" name = "direccion" id = "direccion" placeholder ="direccion" required><br><br>

                <label for = "codigoPostal">Coódigo Postal:</label><br>
                <input type = "text" name = "codigoPostal" id = "codigoPostal" placeholder ="codigo postal" required><br><br>

                <label for = "ciudad">Ciudad:</label><br>
                <input type = "text" name = "ciudad" id = "ciudad" placeholder ="ciudad" required><br><br>

                <label for = "pais">País:</label><br>
                <input type = "text" name = "pais" id = "pais" placeholder ="país" required><br><br>

                <label for = "password">Contraseña:</label><br>
                <input type = "password" name = "password" id = "password" placeholder ="contraseña" required><br><br>

                <button type = "submit">Registrar</button>
            </form>        
        <p><a href = "/?url=registro/registrar"><- Volver al inicio del registro</a></p>
        </main>
    </body>
</html>