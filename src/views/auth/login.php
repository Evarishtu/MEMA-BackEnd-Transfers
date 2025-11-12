<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
<style>
    body {
      font-family: Arial, sans-serif;
      margin: 40px;
      line-height: 1.6;
    }

    header h1 {
      color: #007bff;
    }

    form {
      margin-top: 20px;
      max-width: 400px;
    }

    label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }

    input, select {
      width: 100%;
      padding: 8px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 14px;
    }

    button {
      background-color: #007bff;
      color: white;
      padding: 10px 16px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 14px;
    }

    button:hover {
      background-color: #0056b3;
    }

    a {
      color: #007bff;
      text-decoration: none;
    }

    a:hover {
      text-decoration: underline;
    }

    .volver {
      display: inline-block;
      margin-top: 10px;
      font-size: 14px;
    }
</style>
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
        <p><a href="/"><- Volver a la página principal</a></p>  
    </body>
</html>