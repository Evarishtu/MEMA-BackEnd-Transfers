<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
    <body>
        <h1>Iniciar sesion</h1>
        <form method = "POST" action = "/?url=login/login">
            <label>Email:</label><br>
            <input type = "email" name = "email" placeholder="tu email" autocomplete="new-email" required><br><br>
            <label>Contraseña</label><br>
            <input type = "password" name = "password" placeholder="tu contraseña" required><br><br>
            <label>Tipo de usuario:</label><br>
            <select name="rol" required>
                <option value = "viajero">Cliente </option>
                <option value = "hotel">Cliente corporativo</option>
                <option value = "administrador">Administrador</option>
            </select><br><br>
            <button type = "submit">Entrar</button>
        </form>
        <p>Darse de alta <a href="/?url=registro/registrar"></a></p> 
    </body>
</html>