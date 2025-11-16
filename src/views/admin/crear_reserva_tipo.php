<?php 
if (session_status() === PHP_SESSION_NONE){
    session_start();
}
if(!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador'){
    header('Location: ?url=login/login');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear reserva - Paso 1</title>

    <style>
        body {
            margin: 0;
            padding: 60px 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #3a7bd5, #00d2ff);
            color: #fff;
            min-height: 100vh;
        }

        .card {
            width: 90%;
            max-width: 450px;
            margin: auto;
            background: rgba(255, 255, 255, 0.32);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 16px;
            color: #003e60;
            box-shadow: 0 4px 12px rgba(0,0,0,0.20);
            text-align: center;
        }

        h1 {
            color: #eaffff;
            margin-top: 0;
        }

        p {
            color: #003e60;
            font-weight: bold;
        }

        label {
            display: block;
            text-align: left;
            margin-bottom: 6px;
            font-weight: bold;
        }

        select {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: none;
            margin-bottom: 18px;
            font-size: 15px;
        }

        button {
            background: #007bff;
            border: none;
            padding: 10px 18px;
            border-radius: 8px;
            color: white;
            cursor: pointer;
            font-weight: bold;
            font-size: 15px;
            width: 100%;
        }

        button:hover {
            background: #0056b3;
        }

        a {
            color: #003354;
            font-weight: bold;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .volver {
            margin-top: 18px;
            display: inline-block;
        }
    </style>
</head>

<body>

<div class="card">

    <h1>Crear nueva reserva</h1>

    <p>Seleccione el tipo de trayecto que desea reservar:</p>

    <form method="POST" action="?url=admin/crearReservaDatos">

        <!-- Tipo de trayecto -->
        <label for="tipo_reserva">Tipo de trayecto:</label>
        <select id="tipo_reserva" name="tipo_reserva" required>
            <option value="">Selecciona tipo de trayecto</option>
            <?php foreach ($tipos_reserva as $tipo): ?>
                <option value="<?= htmlspecialchars($tipo['id_tipo_reserva']) ?>">
                    <?= htmlspecialchars($tipo['descripcion']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Continuar</button>
    </form>

    <p class="volver">
        <a href="?url=admin/dashboard">⬅️ Volver al panel principal</a>
    </p>

</div>

</body>
</html>