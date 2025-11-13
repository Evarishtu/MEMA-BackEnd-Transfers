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
    <style>
        body {
        font-family: Arial, sans-serif;
        margin: 40px;
        line-height: 1.6;
        }

        h1 {
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
        margin-top: 15px;
        display: inline-block;
        }
    </style>
</head>
    <body>
        <h1>Crear nueva reserva</h1>
        <p>Seleccione el tipo de trayecto que desea reservar: </p>
        <form method = "POST" action = "/?url=admin/crearReservaDatos">
            <label for = "tipo_reserva">Tipo de trayecto:</label><br>
            <select id = "tipo_reserva" name = "tipo_reserva" required>
                <option value = "">Selecciona tipo de trayecto</option>
                <?php foreach ($tipos_reserva as $tipo): ?>
                    <option value = "<?= htmlspecialchars($tipo['id_tipo_reserva'])?>">
                        <?= htmlspecialchars($tipo['descripcion'])?>
                    </option>
                <?php endforeach; ?>
            </select><br><br>
            <button type = "submit">Continuar</button>
        </form>
        <p><a href = "/?url=admin/dashboard">⬅️ Volver al panel principal</a></p>
    </body>
</html>