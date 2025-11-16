<?php 
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'viajero') {
  header('Location: ?url=login/login');
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
      margin: 0;
      font-family: "Arial", sans-serif;
      background: linear-gradient(135deg, #3a7bd5, #00d2ff);
      color: #fff;
      display: flex;
      justify-content: center;
      padding-top: 120px;
      padding-bottom: 80px;
      min-height: 100vh;
    }

    .card {
      width: 90%;
      max-width: 700px;
      background: rgba(255, 255, 255, 0.35);
      backdrop-filter: blur(10px);
      border-radius: 18px;
      padding: 35px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
      color: #fff;
    }

    h1 {
      text-align: center;
      margin-top: 0;
      margin-bottom: 25px;
      font-size: 32px;
      font-weight: bold;
    }

    fieldset {
      border: none;
      background: rgba(255,255,255,0.15);
      border-radius: 12px;
      padding: 20px;
      margin-bottom: 25px;
    }

    legend {
      font-size: 18px;
      font-weight: bold;
      padding: 0 6px;
      margin-bottom: 10px;
    }

    label {
      display: block;
      margin-top: 12px;
      font-weight: bold;
    }

    input, select {
      margin-top: 6px;
      width: 100%;
      padding: 12px;
      border-radius: 10px;
      border: none;
      outline: none;
      font-size: 15px;
    }

    button {
      width: 100%;
      padding: 14px;
      background: #1f8fff;
      border: none;
      color: #fff;
      font-size: 17px;
      border-radius: 12px;
      cursor: pointer;
      margin-top: 10px;
      transition: 0.3s;
      font-weight: bold;
    }

    button:hover {
      background: #0066cc;
    }

    a.volver {
      display: block;
      text-align: center;
      margin-top: 20px;
      text-decoration: none;
      font-size: 16px;
      color: #e5f3ff;
      font-weight: bold;
    }

    a.volver:hover {
      text-decoration: underline;
    }
  </style>

</head>
<body>

  <div class="card">
    <h1>📝 Crear Reserva</h1>

    <form method="POST" action="?url=viajero/guardarReserva">

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




      <!-- =============================== -->
      <!-- BLOQUE: VUELO SALIDA PRIMERO -->
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
      <!-- BLOQUE: VUELO LLEGADA DESPUÉS -->
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

    <a href="?url=viajero/dashboard" class="volver">← Volver al dashboard</a>
  </div>

  <script>
    function mostrarCampos() {
      const tipo = document.getElementById('tipo_reserva').value;

      document.getElementById('vuelo_salida').style.display = 
        (tipo == "1" || tipo == "3") ? 'block' : 'none';

      document.getElementById('vuelo_llegada').style.display = 
        (tipo == "2" || tipo == "3") ? 'block' : 'none';
    }


function validarHorasYFechas() {

    const tipo = document.getElementById('tipo_reserva').value;

    // Campos de ida
    const fechaSalida   = document.querySelector('input[name="fecha_vuelo_salida"]');
    const horaSalida    = document.querySelector('input[name="hora_vuelo_salida"]');

    // Campos de vuelta
    const fechaLlegada  = document.querySelector('input[name="fecha_entrada"]');
    const horaLlegada   = document.querySelector('input[name="hora_entrada"]');

    // Hora de recogida
    const horaRecogida  = document.querySelector('input[name="hora_recogida"]');

    // Reset de todos los mensajes
    horaRecogida.setCustomValidity("");
    fechaSalida.setCustomValidity("");
    horaSalida.setCustomValidity("");


    switch (tipo) {
        // Hotel → Aeropuerto
        case "1":

            if (horaRecogida.value && horaSalida.value) {
                // Recogida > salida
                if (horaRecogida.value > horaSalida.value) {
                    horaRecogida.setCustomValidity(
                        "La hora de recogida no puede ser posterior a la hora del vuelo."
                    );
                }
                // Recogida == salida
                if (horaRecogida.value === horaSalida.value) {
                    horaRecogida.setCustomValidity(
                        "La hora de recogida no puede ser igual a la hora del vuelo."
                    );
                }
            }
            break;


        // Aeropuerto → Hotel
        case "2":
            // No hay validaciones específicas para este tipo
            break;

        //Aeropuerto → Hotel → Aeropuerto)
        case "3":
            // Validación de hora recogida 
            if (horaRecogida.value && horaSalida.value) {

                if (horaRecogida.value > horaSalida.value) {
                    horaRecogida.setCustomValidity(
                        "La hora de recogida no puede ser posterior a la hora de salida del vuelo."
                    );
                }

                if (horaRecogida.value === horaSalida.value) {
                    horaRecogida.setCustomValidity(
                        "La hora de recogida no puede ser igual a la hora de salida del vuelo."
                    );
                }
            }

            //Vuelo ida posterior al vuelo vuelta
            if (fechaSalida.value && fechaLlegada.value) {

                if (fechaSalida.value > fechaLlegada.value) {
                    fechaSalida.setCustomValidity(
                        "La fecha del vuelo de ida no puede ser posterior a la fecha del vuelo de vuelta."
                    );
                }
            }

            // Si son el mismo día → validar horas ida/vuelta
            if (fechaSalida.value && fechaLlegada.value && fechaSalida.value === fechaLlegada.value) {

                if (horaSalida.value && horaLlegada.value) {

                    if (horaSalida.value > horaLlegada.value) {
                        horaSalida.setCustomValidity(
                            "La hora del vuelo de ida no puede ser posterior a la hora del vuelo de vuelta."
                        );
                    }

                    if (horaSalida.value === horaLlegada.value) {
                        horaSalida.setCustomValidity(
                            "La hora del vuelo de ida no puede ser igual a la hora del vuelo de vuelta."
                        );
                    }
                }
            }

            break;

        default:
            break;
    }
}

  // ===============================
  // Conectar eventos
  // ===============================
  document.addEventListener("DOMContentLoaded", () => {

      const tipo = document.getElementById('tipo_reserva');

      document.querySelectorAll(
          'input[name="hora_vuelo_salida"], input[name="hora_recogida"], input[name="hora_entrada"], input[name="hora_vuelo_salida"], input[name="fecha_vuelo_salida"], input[name="fecha_entrada"]'
      ).forEach(el => {
          el.addEventListener("change", validarHorasYFechas);
      });

      tipo.addEventListener("change", validarHorasYFechas);
  });

    </script>

</body>
</html>

