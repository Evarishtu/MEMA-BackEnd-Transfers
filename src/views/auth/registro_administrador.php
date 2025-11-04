<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
    <body>
        <h2>Registro de Administrador</h2>
        <form method = "POST" action = "/?url=registro/registrar">
            <input type = "hidden" name = "rol" value = "administrador">

            <label for = "email">Email de autenticación de usuario</label><br>
            <input type = "email" name = "email" placeholder = "tu email" required><br><br>

            <label for = "password">Contraseña de usuario</label><br>
            <input type = "password" name = "password" placeholder = "contraseña de usuario" required><br><br>

            <label for = "nombre">Nombre:</label><br>
            <input type = "text" name = "nombre" placeholder = "tu nombre" required><br><br>

            <button type = "submit">Registrar</button>               
    </body>
</html>