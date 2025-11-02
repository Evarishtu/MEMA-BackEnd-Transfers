<?php
$rol = $_POST['rol'] ?? '';
$email = $_POST['email'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
</head>
    <body>
        <header>
            <h1>Registro de nuevo usuario</h1>
        </header>
        <nav>
            <ul>
                <li><a href="./dashboard.php">Volver al panel principal</a></li>
            </ul>
        </nav>
        <main>
            <?php if(empty($rol)): ?>    
                <!--Selección de rol-->
                <form method = "POST" action = "">
                    <label>Tipo de usuario: </label><br>
                    <select name = "rol" required>
                        <option value = "">--Seleccione tipo de usuario--</option>
                        <option value = "viajero">Cliente particular</option>
                        <option value = "hotel">Cliente corporativo</option>
                        <option value = "administrador">Administrador</option>
                    </select><br><br>
                    <button type = "submit">Continuar</button>
                </form>
                
            <?php elseif($rol == 'viajero' && empty($email)): ?>
                <!--Formulario de viajero-->
                <h2>Registro de cliente particular</h2>
                <form method = "POST" action ="/?url=auth/registro">
                    <input type = "hidden" id = "rol" name = "rol" value ="viajero">

                    <label for = "email">Email de autenticación de usuario:</label><br>
                    <input type = "email" id = "email" name = "email" placeholder = "tu email" required><br><br>

                    <label for = "password">Contraseña de usuario:</label><br>
                    <input type = "password" id = "password" name = "password" placeholder = "contraseña de usuario" required><br><br>

                    <label for = "nombre_cliente">Nombre:</label><br>
                    <input type = "text" id = "nombre_cliente" name = "nombre_cliente" placeholder ="tu nombre" required><br><br>

                    <label for = "apellido1">Primer apellido:</label><br>
                    <input type = "text" id = "apellido1" name = "apellido1" placeholder ="tu primer apellido" required><br><br>

                    <label for = "apellido2">Segundo apellido:</label><br>
                    <input type = "text" id = "apellido2" name = "apellido2" placeholder ="tu segundo apellido" required><br><br>

                    <label for = "direccion">Dirección:</label><br>
                    <input type = "text" id = "direccion" name = "direccion" placeholder ="tu dirección" required><br><br>

                    <label for = "codigo_postal">Código postal:</label><br>
                    <input type = "text" id = "codigo_postal" name = "codigo_postal" placeholder ="tu código postal" required><br><br>

                    <label for = "pais">País:</label><br>
                    <input type = "text" id = "pais" name = "pais" placeholder ="tu país" required><br><br>

                    <label for = "ciudad">Ciudad:</label><br>
                    <input type = "text" id = "ciudad" name = "ciudad" placeholder ="tu ciudad" required><br><br>

                    <button type = "submit">Registrar</button>
                </form>
            <!--Formulario de hotel-->
            <?php elseif($rol == 'hotel' && empty($email)): 
                echo "<p>El panel para los usuarios corporativos no está desarrollado en este producto</p>";
                ?>
            <?php elseif($rol == 'administrador' && empty($email)): ?>
            <!--Formulario de administrador-->
                <h2>Registro de administrador</h2>
                <form method = "POST" action = "/?url=auth/registro">
                    <input type = "hidden" id = "rol" name = "rol" value = "administrador">

                    <label for = "email">Email de autenticación de usuario</label><br>
                    <input type = "email" id = "email" name = "email" placeholder = "tu email" required><br><br>

                    <label for = "password">Contraseña de usuario</label><br>
                    <input type = "password" id = "password" name = "password" placeholder = "contraseña de usuario" required><br><br>

                    <label for = "nombre">Nombre:</label><br>
                    <input type = "text" id = "nombre" name = "nombre" placeholder = "tu nombre" required><br><br>

                    <button type = "submit">Registrar</button>
                </form>
            <?php endif ?>        
        </main>    
    </body>
</html>

