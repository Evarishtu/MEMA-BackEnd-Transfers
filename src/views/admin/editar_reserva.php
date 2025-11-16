<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
  header('Location: ?url=login/login'); exit;
}

$r = $reserva ?? [];
$tipo_sel = (string)($r['id_tipo_reserva'] ?? '');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar reserva</title>

    <!-- 🔵 Aquí Mantén TODO tu CSS EXACTO como lo tenías -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 60px 0;
            background: linear-gradient(135deg, #3a7bd5, #00d2ff);
            min-height: 100vh;
            color: #fff;
        }

        .card {
            width: 95%;
            max-width: 850px;
            margin: auto;
            background: rgba(255,255,255,0.35);
            backdrop-filter: blur(10px);
            padding: 35px;
            border-radius: 16px;
            color: #003e60;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }

        h1 {
            text-align: center;
            color: #eaffff;
            margin-top: 0;
            margin-bottom: 30px;
        }

        fieldset {
            border: none;
            margin-bottom: 30px;
            background: rgba(255,255,255,0.25);
            padding: 20px;
            border-radius: 12px;
        }

        legend {
            font-weight: bold;
            color: #003e60;
            margin-bottom: 10px;
            font-size: 18px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-top: 10px;
            color: #003e60;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 4px;
            border: none;
            border-radius: 8px;
            background: #fff;
            font-size: 14px;
        }

        button {
            background: #006bb3;
            color: white;
            padding: 12px 22px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            font-size: 15px;
        }

        button:hover {
            background: #005c99;
        }

        a {
            color: #003a5c;
            font-weight: bold;
            text-decoration: none;
            margin-left: 15px;
        }

        a:hover {
            text-decoration: underline;
        }

        .actions {
            text-align: center;
            margin-top: 25px;
        }
    </style>
</head>

<body>

<div class="card">

    <h1>Editar reserva <?= htmlspecialchars($r['localizador'] ?? '') ?></h1>

    <form method="POST" action="?url=admin/actualizarReserva">

        <input type="hidden" name="id_reserva" value="<?= htmlspecialchars($r['id_reserva'] ?? '') ?>">

        <!-- DATOS GENERALES -->
        <fieldset>
            <legend>Datos generales</legend>

            <label>Tipo de reserva:</label>
            <select name="id_tipo_reserva" id="tipo_reserva" required onchange="mostrarCampos()">
                <?php foreach(($tipos_reserva ?? []) as $t): ?>
                    <option value="<?= htmlspecialchars($t['id_tipo_reserva']) ?>"
                        <?= ($tipo_sel === (string)$t['id_tipo_reserva']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($t['descripcion']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Hotel:</label>
            <select name="id_hotel" required>
                <?php foreach(($hoteles ?? []) as $h): ?>
                    <option value="<?= htmlspecialchars($h['id_hotel']) ?>"
                        <?= ((string)$r['id_hotel'] === (string)$h['id_hotel']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($h['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Email del cliente:</label>
            <input type="email" name="email_cliente"
                   value="<?= htmlspecialchars($r['email_cliente'] ?? '') ?>" required>

            <label>Número de viajeros:</label>
            <input type="number" name="num_viajeros"
                   value="<?= htmlspecialchars($r['num_viajeros'] ?? '') ?>" required>

            <label>Vehículo asignado:</label>
            <select name="id_vehiculo" required>
                <?php foreach(($vehiculos ?? []) as $v): ?>
                    <option value="<?= htmlspecialchars($v['id_vehiculo']) ?>"
                        <?= ((string)$r['id_vehiculo'] === (string)$v['id_vehiculo']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($v['descripcion']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </fieldset>

        <!-- AEROPUERTO → HOTEL -->
        <fieldset id="bloque_llegada">
            <legend>Aeropuerto → Hotel</legend>

            <label>Fecha llegada:</label>
            <input type="date" name="fecha_entrada" value="<?= htmlspecialchars($r['fecha_entrada'] ?? '') ?>">

            <label>Hora llegada:</label>
            <input type="time" name="hora_entrada" value="<?= htmlspecialchars($r['hora_entrada'] ?? '') ?>">

            <label>Número vuelo llegada:</label>
            <input type="text" name="numero_vuelo_entrada" value="<?= htmlspecialchars($r['numero_vuelo_entrada'] ?? '') ?>">

            <label>Aeropuerto origen:</label>
            <input type="text" name="origen_vuelo_entrada" value="<?= htmlspecialchars($r['origen_vuelo_entrada'] ?? '') ?>">
        </fieldset>

        <!-- HOTEL → AEROPUERTO -->
        <fieldset id="bloque_salida">
            <legend>Hotel → Aeropuerto</legend>

            <label>Fecha vuelo salida:</label>
            <input type="date" name="fecha_vuelo_salida" value="<?= htmlspecialchars($r['fecha_vuelo_salida'] ?? '') ?>">

            <label>Hora vuelo salida:</label>
            <input type="time" name="hora_vuelo_salida" value="<?= htmlspecialchars($r['hora_vuelo_salida'] ?? '') ?>">

            <label>Número vuelo salida:</label>
            <input type="text" name="numero_vuelo_salida" value="<?= htmlspecialchars($r['numero_vuelo_salida'] ?? '') ?>">

            <label>Hora recogida:</label>
            <input type="time" name="hora_recogida" value="<?= htmlspecialchars($r['hora_recogida'] ?? '') ?>">
        </fieldset>

        <div class="actions">
            <button type="submit">Guardar cambios</button>
            <a href="?url=admin/verReserva&id=<?= urlencode($r['id_reserva'] ?? '') ?>">Cancelar</a>
        </div>

    </form>

</div>

<script>
function mostrarCampos() {
    const tipo = document.getElementById('tipo_reserva').value;
    const llegada = document.getElementById('bloque_llegada');
    const salida  = document.getElementById('bloque_salida');

    if (tipo === "1") { llegada.style.display = "none"; salida.style.display = "block"; }
    else if (tipo === "2") { llegada.style.display = "block"; salida.style.display = "none"; }
    else { llegada.style.display = "block"; salida.style.display = "block"; }
}

document.addEventListener("DOMContentLoaded", mostrarCampos);
</script>

</body>
</html>
