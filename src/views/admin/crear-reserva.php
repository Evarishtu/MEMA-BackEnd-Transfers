<?php // Comprobar si el usuario logueado es administrador
$tipo_reserva = $_POST['tipo_reserva'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear una nueva reserva</title>
</head>
    <body>
        <header>
            <h1>Crear nueva reserva</h1>
        </header>
        <nav>
            <ul>
                <li><a href="./dashboard.php">Volver al panel principal</a></li>
            </ul>
        </nav>
        <main>
            <form method = "POST" action = "">
                <h2>Tipo de trayecto</h2>

            <!--Tipo de trayecto-->
                <label for = "tipo_reserva">Tipo de trayecto:</label><br>
                <select id = "tipo_reserva" name = "tipo_reserva" required>
                    <option value = "">Selecciona tipo de trayecto</option>
                    <option value = "1" <?= $tipo_reserva == '1' ? 'selected' : ''?>>Aeropuerto -> Hotel</option>
                    <option value = "2" <?= $tipo_reserva == '2' ? 'selected' : ''?>>Hotel -> Aeropuerto</option>
                    <option value = "3" <?= $tipo_reserva == '3' ? 'selected' : ''?>>Ida y vuelta</option>
                </select><br><br>
                <button type = "submit" name = "elegir_tipo">Continuar</button>
            </form>
            <?php var_dump($tipo_reserva) ?>
            <?php if ($tipo_reserva): ?>
                <hr>
                <h2>Datos de la reserva</h2>
                <form method = "POST" action = "">
                    <input type = "hidden" name = "tipo_reserva" value = "<?= $tipo_reserva ?>">

                <?php if ($tipo_reserva == "1" || $tipo_reserva == "3"): ?>   
                    <!--Datos del vuelo de llegada-->
                    <fieldset>
                        <legend>Vuelo de llegada</legend>
                        <label for = "fecha_llegada">Fecha llegada:</label><br>
                        <input type = "date" id = "fecha_llegada" name = "fecha_llegada"><br><br>

                        <label for = "hora_llegada">Hora llegada:</label><br>
                        <input type = "time" id = "hora_llegada" name = "hora_llegada"><br><br>

                        <label for = "numero_vuelo_llegada">Número de vuelo:</label><br>
                        <input type = "text" id = "numero_vuelo_llegada" name = "numero_vuelo_llegada"><br><br>

                        <label for = "origen_vuelo">Aeropuerto de origen:</label><br>
                        <input type = "text" id = "origen_vuelo" name ="origen_vuelo"><br><br>
                    </fieldset>
                <?php endif; ?>
            
                <?php if ($tipo_reserva == "2" || $tipo_reserva == "3"): ?>
                    <!--Datos del vuelo de salida-->
                    <fieldset>
                        <legend>Vuelo de salida</legend>
                        <label for = "fecha_salida">Fecha vuelo:</label><br>
                        <input type = "date" id = "fecha_salida" name = "fecha_salida"><br><br>

                        <label for = "hora_salida">Hora vuelo:</label><br>
                        <input type = "time" id = "hora_salida" name = "hora_salida"><br><br>

                        <label for = "num_vuelo_salida">Número de vuelo:</label><br>
                        <input type = "text" id = "num_vuelo_salida" name = "num_vuelo_salida"><br><br>
                        
                        <label for = "hora_recogida">Hora recogida en hotel:</label><br>
                        <input type = "time" id = "hora_recogida" name = "hora_recogida"><br><br>
                    </fieldset>
                <?php endif; ?>

                    <!--Hotel-->
                    <label for = "hotel">Hotel destino/recogida:</label><br>
                    <input type = "text" id = "hotel" name = "hotel" required><br><br>

                    <!--Datos del cliente-->
                    <fieldset>
                        <legend>Datos del cliente</legend>
                        <label for = "nombre_cliente">Nombre:</label><br>
                        <input type = "text" id = "nombre_cliente" name = "nombre_cliente" required><br><br>

                        <label for = "email_cliente">Email:</label><br>
                        <input type = "email" id = "email_cliente" name = "email_cliente" required><br><br>

                        <label for = "num_viajeros">Número de viajeros:</label><br>
                        <input type = "text" id = "num_viajeros" name = "num_viajeros" min = "1" required><br><br>
                    </fieldset>
                    <!--Vehí<culo-->
                    <label for = "vehiculo">Vehículo asignado:</label><br>
                    <input type = "text" id = "vehiculo" name = "vehiculo"><br><br>
                    
                    <!--Botón-->
                    <button type = "submit" name = "crear_reserva">Crear reserva</button>
                </form>
            <?php endif; ?>
        </main>
    </body>
</html>