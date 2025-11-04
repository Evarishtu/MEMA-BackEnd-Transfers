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
                    <option value = "hotel">Cliente corporativo</option>
                    <option value = "administrador">Administrador</option>
                </select><br><br>
                <button type = "submit">Continuar</button>
            </form>       
        </main>    
    </body>
</html>

