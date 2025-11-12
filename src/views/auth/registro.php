<?php
$rol = $_POST['rol'] ?? '';
$email = $_POST['email'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Seleccionar</title>
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

    select {
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
        <header>
            <h1>Registro de nuevo usuario</h1>
        </header>
        <main>
            <form method = "POST" action = "?url=registro/registrar">
                <label>Tipo de usuario: </label><br>
                <select name = "rol" required>
                    <option value = "">--Seleccione tipo de usuario--</option>
                    <option value = "viajero">Cliente particular</option>
                    <option value = "hotel">Cliente Corporativo (Hotel)</option>
                    <option value = "administrador">Administrador</option>
                </select><br><br>
                <button type = "submit">Continuar</button>
            </form> 
            <p><a href="/"><- Volver a la página principal</a></p>      
        </main>    
    </body>
</html>

