<?php // Comprobar si el usuario logueado es administrador ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
</head>
    <body>
        <header>
            <h1>Panel de Administración</h1>
        </header> 
        <nav>
            <ul>
                <li><a href="../auth/login.php">Cerrar sesión</a></li>
            </ul>
        </nav>
        <main>
            <section>
                <h2>Gestión de reservas</h2>
                <ul>
                    <li><a href="./crear-reserva.php">Crear nueva reserva</a></li>
                    <li><a href="./listar-reservas.php">Consultar y gestionar las reservas</a></li>
                </ul>
            </section>
        </main>
        <footer>
            
        </footer>
    </body>
</html>