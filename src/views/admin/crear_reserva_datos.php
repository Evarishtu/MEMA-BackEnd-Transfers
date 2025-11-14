<?php 
if (session_status() === PHP_SESSION_NONE){
    session_start();
}

if(!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador'){
    header('Location: /?url=login/login');
    exit;
}

$tipo_reserva = $_POST['tipo_reserva'] ?? ($_GET['tipo_reserva'] ?? '');
if(!$tipo_reserva){
    header('Location: /?url=admin/crearReserva');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear reserva - Paso 2</title>

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
            max-width: 700px;
            margin: auto;
            background: rgba(255, 255, 255, 0.32);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 16px;
            color: #003e60;
            box-shadow: 0 4px 12px rgba(0,0,0,0.20);
        }

        h1 {
            text-align: center;
            color: #eaffff;
            margin-top: 0;
        }

        fieldset {
            border: none;
            background: rgba(255,255,255,0.35);
            padding: 18px;
            border-radius: 12px;
            margin-bottom: 22px;
        }

        legend {
            font-weight: bold;
            color: #003e60;
            padding-bottom: 8px;
        }

        label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }

        input, select {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: none;
            margin-top: 6px;
            font-size: 15px;
        }

        button {
            width: 100%;
            background: #007bff;
            border: none;
            padding: 12px;
            border-radius: 8px;
            color: white;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background: #0056b3;
        }

        a {
            color: #003354;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        .volver {
            text-align: center;
            margin-top: 18px;
        }
    </style>
</head>

<body>

<div class="card">

    <h1>Datos de la reserva</h1>

    <form method="POST" action="/?url=admin/guardarReserva">

        <input type="hidden" name="tipo_reserva" value="<?= htmlspecialchars($tipo_reserva) ?>">

        <?php if ($tipo_reserva == "1" || $tipo_reserva == "3"): ?>
            <!-- Datos del vuelo de llegada -->
            <fieldset>
                <legend>Vuelo de llegada (Aeropuerto → Hotel)</legend>

                <label>Fecha llegada:</label>
                <input type="date" name="fecha_llegada">

                <label>Hora llegada:</label>
                <input type="time" name="hora_llegada">

                <label>Número de vuelo:</label>
                <input type="text" name="numero_vuelo_llegada">

                <label>Aeropuerto de origen:</label>
                <input type="text" name="origen_vuelo">
            </fieldset>
        <?php endif; ?>

        <?php if ($tipo_reserva == "2" || $tipo_reserva == "3"): ?>
            <!-- Datos del vuelo de salida -->
            <fieldset>
                <legend>Vuelo de salida (Hotel → Aeropuerto)</legend>

                <label>Fecha vuelo:</label>
                <input type="date" name="fecha_salida">

                <label>Hora vuelo:</label>
                <input type="time" name="hora_salida">

                <label>Número de vuelo:</label>
                <input type="text" name="numero_vuelo_salida">

                <label>Hora recogida en hotel:</label>
                <input type="time" name="hora_recogida">
            </fieldset>
        <?php endif; ?>

        <!-- Datos adicionales -->
        <fieldset>
            <legend>Datos adicionales</legend>

            <label>Hotel de origen/destino</label>
            <select name="id_hotel" required>
                <option value="">--Selecciona un hotel--</option>
                <?php foreach ($hoteles as $hotel): ?>
                    <option value="<?= htmlspecialchars($hotel['id_hotel']) ?>">
                        <?= htmlspecialchars($hotel['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Número de viajeros</label>
            <input type="number" name="numero_viajeros">

            <label>Email del cliente</label>
            <input type="email" name="email_cliente" value="<?= htmlspecialchars($email_cliente_precargado ?? '') ?>" required>

            <label>Vehículo asignado</label>
            <select name="id_vehiculo" required>
                <option value="">--Selecciona un vehículo--</option>
                <?php foreach ($vehiculos as $vehiculo): ?>
                    <option value="<?= htmlspecialchars($vehiculo['id_vehiculo']) ?>">
                        <?= htmlspecialchars($vehiculo['descripcion']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Guardar reserva</button>
        </fieldset>

    </form>

    <p class="volver"><a href="/?url=admin/crearReserva">⬅ Volver al paso anterior</a></p>

</div>

</body>
</html>