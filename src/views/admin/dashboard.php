<?php 
if (session_status() === PHP_SESSION_NONE){
    session_start();
}

if(!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador'){
    header('Location: /?url=login/login');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <style>
        body {
        font-family: Arial, sans-serif;
        margin: 40px;
        line-height: 1.6;
        }

        header h1 {
        color: #007bff;
        }

        nav ul {
        list-style: none;
        padding: 0;
        margin: 15px 0;
        }

        nav li {
        display: inline-block;
        margin-right: 15px;
        }

        a {
        color: #007bff;
        text-decoration: none;
        }

        a:hover {
        text-decoration: underline;
        }

        section {
        margin-top: 30px;
        }

        h2 {
        color: #333;
        margin-bottom: 10px;
        }

        ul {
        list-style: none;
        padding-left: 0;
        }

        ul li {
        margin: 8px 0;
        }
    </style>
</head>
    <body>
        <header>
            <h1>Bienvenido, <?=htmlspecialchars($_SESSION['user_nombre'])?></h1>
        </header> 
        <nav>
            <li><a href="/?url=login/logout">Cerrar sesión</a></li>
        </nav>
        <main>
            <section>
                <h2>Gestión de reservas</h2>
                <ul>
                    <li><a href="/?url=admin/crearReserva">Crear nueva reserva</a></li>
                    <li><a href="/?url=admin/listarReservas">Consultar y gestionar las reservas</a></li>
                </ul>
            </section>
        </main>
       
    </body>
</html>