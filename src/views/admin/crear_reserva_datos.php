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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear reserva - Paso 2</title>
</head>
    <body>
        <h1>Datos de la reserva</h1>
        <form method = "POST" action = "/?url=admin/guardarReserva">
        <input type="hidden" name="tipo_reserva" value="<?= htmlspecialchars($tipo_reserva) ?>">
        <?php if ($tipo_reserva == "1" || $tipo_reserva == "3"): ?>   
            <!--Datos del vuelo de llegada-->
            <fieldset>
                <legend>Vuelo de llegada (Aeropuerto->Hotel)</legend>
                <label for = "fecha_llegada">Fecha llegada:</label><br>
                <input type = "date" name = "fecha_llegada"><br><br>

                <label for = "hora_llegada">Hora llegada:</label><br>
                <input type = "time" name = "hora_llegada"><br><br>

                <label for = "numero_vuelo_llegada">Número de vuelo:</label><br>
                <input type = "text" name = "numero_vuelo_llegada"><br><br>

                <label for = "origen_vuelo">Aeropuerto de origen:</label><br>
                <input type = "text" name ="origen_vuelo"><br><br>
            </fieldset>
        <?php endif; ?>

        <?php if ($tipo_reserva == "2" || $tipo_reserva == "3"): ?>
            <!--Datos del vuelo de salida-->
            <fieldset>
                <legend>Vuelo de salida (Hotel->Aeropuerto)</legend>
                <label for = "fecha_salida">Fecha vuelo:</label><br>
                <input type = "date" name = "fecha_salida"><br><br>

                <label for = "hora_salida">Hora vuelo:</label><br>
                <input type = "time" name = "hora_salida"><br><br>

                <label for = "numero_vuelo_salida">Número de vuelo:</label><br>
                <input type = "text" name = "numero_vuelo_salida"><br><br>
                
                <label for = "hora_recogida">Hora recogida en hotel:</label><br>
                <input type = "time" name = "hora_recogida"><br><br>
            </fieldset>
        <?php endif; ?>
            <fieldset>
                <legend>Datos adicionales</legend>
            <!--Hotel origen destino-->
                <label for = "hotel">Hotel de origen/destino</label><br>
                <select id = "hotel" name = "id_hotel" required>
                    <option value = "">--Selecciona un hotel--</option>
                    <?php foreach ($hoteles as $hotel): ?>
                        <option value = "<?= htmlspecialchars($hotel['id_hotel']) ?>">
                            <?= htmlspecialchars($hotel['nombre'])?>
                        </option>
                    <?php endforeach; ?>
                </select><br><br>
            <!--Número de viajeros-->
                <label for = "numero_viajeros">Número de viajeros</label><br>
                <input type = "number" name = "numero_viajeros"><br><br>
            <!--Información personal-->
                <label for = "email_cliente">Email del cliente</label><br>
                <input type="email" name="email_cliente" value="<?= htmlspecialchars($email_cliente_precargado ?? '') ?>" required><br><br>
            <!--Vehículo-->
                <label for = "vehiculo">Vehículo asignado</label><br>
                <select id = "vehiculo" name = "id_vehiculo" required>
                    <option value = "">--Selecciona un vehículo--</option>
                    <?php foreach ($vehiculos as $vehiculo): ?>
                        <option value = "<?= htmlspecialchars($vehiculo['id_vehiculo']) ?>">
                            <?= htmlspecialchars($vehiculo['Descripción']) ?>
                        </option>
                    <?php endforeach; ?>
                </select><br><br>
                <button type = "submit">Guardar reserva</button>
            </fieldset>
        </form>
        <p><a href = "/?url=admin/crearReserva">Volver al paso anterior</a></p>   
    </body>
</html>