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
    <title>Crear reserva - Paso 1</title>
</head>
    <body>
        <h1>Crear nueva reserva</h1>
        <p>Seleccione el tipo de trayecto que desea reservar: </p>
        <form method = "POST" action = "/?url=admin/crearReservaDatos">
            <label for = "id_tipo_reserva">Tipo de trayecto:</label><br>
            <select id = "tipo_reserva" name = "tipo_reserva" required>
                <option value = "">Selecciona tipo de trayecto</option>
                <option value = "1">Aeropuerto->Hotel</option>
                <option value = "2">Hotel -> Aeropuerto</option>
                <option value = "3">Ida y vuelta</option>
            </select><br><br>
            <button type = "submit">Continuar</button>
        </form>
        <p><a href = "/?url=admin/dashboard">Volver al panel principal</a></p>
    </body>
</html>