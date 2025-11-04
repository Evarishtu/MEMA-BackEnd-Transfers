<?php 
if (session_status() === PHP_SESSION_NONE){
    session_start();
}

if(!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador'){
    header('Location: /?url=login/login');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
</head>
    <body>
        <header>
            <h1>Bienvenido, <?=htmlspecialchars($_SESSION['user_nombre'])?></h1>
        </header> 
        <nav>
            <ul>
                <li><a href="/?url=login/logout">Cerrar sesión</a></li>
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