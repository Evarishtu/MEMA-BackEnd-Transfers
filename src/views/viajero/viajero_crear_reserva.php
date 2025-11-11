<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Seguridad básica
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'viajero') {
    header('Location: /?url=login/login');
    exit;
}

$email_cliente = $_SESSION['user_email'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Reserva</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background: #f5f5f5;
        }
        h1 {
            color: #333;
        }
        form {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }
        fieldset {
            margin-bottom: 20px;
            border-radius: 8px;
            border: 1px solid #ccc;
            padding: 15px;
        }
        legend {
            font-weight: bold;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input, select, button {
            margin-top: 5px;
            padding: 8px;
            width: 100%;
            box-sizing: border-box;
        }
        button {
            background: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            font-weight: bold;
        }
        button:hover {
            background: #0056b3;
        }
        .volver {
            display: inline-block;
            margin-top: 15px;
        }
    </style>
</head>
<body>

    <h1>Crear nueva reserva</h1>

    <form method="POST" action="/?url=viajero/guardarReserva">
        
        <!-- Tipo de reserva -->
        <fieldset>
            <legend>Tipo de reserva</legend>
            <select name="id_tipo_reserva" id="tipo_reserva" required onchange="mostrarCampos()">
                <option value="">-- Selecciona tipo de reserva --</option>
                <?php foreach ($tiposReserva as $tipo): ?>
                    <option value="<?= htmlspecialchars($tipo['id_tipo_reserva']) ?>">
                        <?= htmlspecialchars($tipo['descripcion']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </fieldset>

        <!-- Datos del vuelo de llegada -->
        <fieldset id="vuelo_llegada" style="display:none;">
            <legend>Vuelo de llegada (Aeropuerto → Hotel)</legend>
            <label>Fecha llegada:</label>
            <input type="date" name="fecha_entrada">

            <label>Hora llegada:</label>
            <input type="time" name="hora_entrada">

            <label>Número de vuelo:</label>
            <input type="text" name="numero_vuelo_entrada">

            <label>Aeropuerto de origen:</label>
            <input type="text" name="origen_vuelo_entrada">
        </fieldset>

        <!-- Datos del vuelo de salida -->
        <fieldset id="vuelo_salida" style="display:none;">
            <legend>Vuelo de salida (Hotel → Aeropuerto)</legend>
            <label>Fecha vuelo salida:</label>
            <input type="date" name="fecha_vuelo_salida">

            <label>Hora vuelo salida:</label>
            <input type="time" name="hora_vuelo_salida">

            <label>Número de vuelo salida:</label>
            <input type="text" name="numero_vuelo_salida">

            <label>Hora recogida en hotel:</label>
            <input type="time" name="hora_recogida">
        </fieldset>

        <!-- Datos adicionales -->
        <fieldset>
            <legend>Datos adicionales</legend>

            <label>Hotel:</label>
            <select name="id_hotel" required>
                <option value="">-- Selecciona un hotel --</option>
                <?php foreach ($hoteles as $hotel): ?>
                    <option value="<?= htmlspecialchars($hotel['id_hotel']) ?>">
                        <?= htmlspecialchars($hotel['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Número de viajeros:</label>
            <input type="number" name="num_viajeros" min="1" required>

            <label>Email del cliente:</label>
            <input type="email" name="email_cliente" value="<?= htmlspecialchars($email_cliente) ?>" readonly>

            <label>Vehículo:</label>
            <select name="id_vehiculo" required>
                <option value="">-- Selecciona un vehículo --</option>
                <?php foreach ($vehiculos as $vehiculo): ?>
                    <option value="<?= htmlspecialchars($vehiculo['id_vehiculo']) ?>">
                        <?= htmlspecialchars($vehiculo['descripcion']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </fieldset>

        <button type="submit">Guardar reserva</button>
    </form>

    <a href="/?url=viajero/dashboard" class="volver">← Volver al dashboard</a>

    <script>
        function mostrarCampos() {
            const tipo = document.getElementById('tipo_reserva').value;
            document.getElementById('vuelo_llegada').style.display = (tipo == "2" || tipo == "3") ? 'block' : 'none';
            document.getElementById('vuelo_salida').style.display = (tipo == "1" || tipo == "3") ? 'block' : 'none';
        }
    </script>

</body>
</html>
