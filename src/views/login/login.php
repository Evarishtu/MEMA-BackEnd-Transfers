<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión - Isla Transfers</title>
</head>
    <body>
        <h1>Acceso a Isla Transfers</h1>
        <form method = "POST" action = "/?url=login/autenticar">
            <label for = "usuario">Correo electrónico o ID de hotel</label><br>
            <input type = "text" name = "usuario" id = "usuario" placeholder="email o ID hotel" required><br><br>
            
            <label for = "password">Contraseña</label><br>
            <input type = "password" name = "password" id ="password" placeholder="tu contraseña" required><br><br>
            
            <button type = "submit">Iniciar sesión</button>
        </form>
        <p>Darse de alta <a href="/?url=registro/registrar"></a></p> 
    </body>
</html>