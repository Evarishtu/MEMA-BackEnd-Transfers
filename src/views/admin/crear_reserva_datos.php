<?php 
if (session_status() === PHP_SESSION_NONE){
    session_start();
}

if(!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador'){
    header('Location: ?url=login/login');
    exit;
}

$tipo_reserva = $_POST['tipo_reserva'] ?? ($_GET['tipo_reserva'] ?? '');
if(!$tipo_reserva){
    header('Location: ?url=admin/crearReserva');
    exit;
}

$nombre_tipo = "";
switch ($tipo_reserva) {
    case "1": $nombre_tipo = "HOTEL → AEROPUERTO"; break;
    case "2": $nombre_tipo = "AEROPUERTO → HOTEL"; break;
    case "3": $nombre_tipo = "IDA Y VUELTA"; break;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
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
    h2 {
        text-align: center;
        color: #003e60;
        margin-top: -10px;
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
</style>

</head>
<body>

<div class="card">

<h1>Datos de la reserva</h1>
<h2>Tipo seleccionado: <strong><?= $nombre_tipo ?></strong></h2>

<form method="POST" action="?url=admin/guardarReserva">

<input type="hidden" name="tipo_reserva" value="<?= htmlspecialchars($tipo_reserva) ?>">

<!-- =============================== -->
<!--         BLOQUE TIPO 1          -->
<!--     HOTEL → AEROPUERTO         -->
<!-- =============================== -->
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


<!-- =============================== -->
<!--         BLOQUE TIPO 2          -->
<!--     AEROPUERTO → HOTEL         -->
<!-- =============================== -->
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


<!-- =============================== -->
<!--        DATOS ADICIONALES       -->
<!-- =============================== -->
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
    <input type="number" name="numero_viajeros" min="1" required>

    <label>Email del cliente:</label>
    <input type="email" name="email_cliente" value="<?= htmlspecialchars($email_cliente_precargado ?? '') ?>" required>

    <label>Vehículo:</label>
    <select name="id_vehiculo" required>
        <option value="">-- Selecciona un vehículo --</option>
        <?php foreach ($vehiculos as $vehiculo): ?>
            <option value="<?= htmlspecialchars($vehiculo['id_vehiculo']) ?>">
                <?= htmlspecialchars($vehiculo['descripcion']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Guardar Reserva</button>
</fieldset>

</form>

<a href="?url=admin/crearReserva">⬅ Volver</a>

</div>


<!-- ========================================================= -->
<!--                SCRIPT EXACTO DEL VIAJERO                  -->
<!-- ========================================================= -->
<script>
function mostrarCampos() {
    const tipo = "<?= $tipo_reserva ?>";

    document.getElementById('vuelo_salida').style.display = 
        (tipo == "1" || tipo == "3") ? 'block' : 'none';

    document.getElementById('vuelo_llegada').style.display = 
        (tipo == "2" || tipo == "3") ? 'block' : 'none';
}

mostrarCampos(); // Ejecutar al entrar


function validarHorasYFechas() {

    const tipo = "<?= $tipo_reserva ?>";

    const fechaSalida   = document.querySelector('input[name="fecha_vuelo_salida"]');
    const horaSalida    = document.querySelector('input[name="hora_vuelo_salida"]');
    const fechaLlegada  = document.querySelector('input[name="fecha_entrada"]');
    const horaLlegada   = document.querySelector('input[name="hora_entrada"]');
    const horaRecogida  = document.querySelector('input[name="hora_recogida"]');

    horaRecogida.setCustomValidity("");
    fechaSalida.setCustomValidity("");
    horaSalida.setCustomValidity("");

    switch (tipo) {

        case "1":
            if (horaRecogida.value && horaSalida.value) {
                if (horaRecogida.value > horaSalida.value) {
                    horaRecogida.setCustomValidity("La hora de recogida no puede ser posterior a la hora del vuelo.");
                }
                if (horaRecogida.value === horaSalida.value) {
                    horaRecogida.setCustomValidity("La hora de recogida no puede ser igual a la hora del vuelo.");
                }
            }
            break;

        case "2":
            break;

        case "3":

            if (horaRecogida.value && horaSalida.value) {
                if (horaRecogida.value > horaSalida.value) {
                    horaRecogida.setCustomValidity("La hora de recogida no puede ser posterior al vuelo.");
                }
                if (horaRecogida.value === horaSalida.value) {
                    horaRecogida.setCustomValidity("La hora de recogida no puede ser igual al vuelo.");
                }
            }

            if (fechaSalida.value && fechaLlegada.value) {
                if (fechaSalida.value < fechaLlegada.value) {
                    fechaSalida.setCustomValidity("La fecha del vuelo de ida no puede ser posterior al de vuelta.");
                }
            }

            if (fechaSalida.value && fechaLlegada.value && fechaSalida.value === fechaLlegada.value) {
                if (horaSalida.value > horaLlegada.value) {
                    horaSalida.setCustomValidity("La hora de ida no puede ser posterior a la de vuelta.");
                }
                if (horaSalida.value === horaLlegada.value) {
                    horaSalida.setCustomValidity("La hora de ida no puede ser igual a la de vuelta.");
                }
            }

            break;
    }
}


// Eventos
document.addEventListener("DOMContentLoaded", () => {

    document.querySelectorAll(
        'input[name="hora_vuelo_salida"], input[name="hora_recogida"], input[name="hora_entrada"], input[name="fecha_vuelo_salida"], input[name="fecha_entrada"]'
    ).forEach(el => {
        el.addEventListener("change", validarHorasYFechas);
    });
});
</script>


</body>
</html>
