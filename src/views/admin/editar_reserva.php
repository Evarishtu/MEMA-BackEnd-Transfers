<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
  header('Location: /?url=login/login'); exit;
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
    <style>
        body {
        font-family: Arial, sans-serif;
        margin: 40px;
        line-height: 1.6;
        }

        h1 {
        color: #007bff;
        margin-bottom: 25px;
        }

        form {
        max-width: 700px;
        }

        fieldset {
        margin-bottom: 25px;
        padding: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
        }

        legend {
        font-weight: bold;
        color: #333;
        }

        label {
        display: block;
        margin-bottom: 10px;
        font-weight: bold;
        }

        input, select {
        width: 100%;
        padding: 8px;
        margin-top: 4px;
        margin-bottom: 12px;
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
        margin-right: 10px;
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
    </style>
</head>
    <body>
        <h1>Editar reserva <?= htmlspecialchars($r['localizador'] ?? '')?></h1>
        <form method = "POST" action = "/?url=admin/actualizarReserva">
            <input type = "hidden" name ="id_reserva" value="<?= htmlspecialchars($r['id_reserva'] ?? '')?>">
            <fieldset>
                <legend>Datos generales</legend>
                <label>Tipo:
                    <select name = "id_tipo_reserva" required>
                        <?php foreach(($tipos_reserva ?? []) as $t): ?>
                            <option value = "<?= htmlspecialchars($t['id_tipo_reserva']) ?>"
                                <?= ($tipo_sel===(string)$t['id_tipo_reserva'])?'selected':''?>>
                                <?= htmlspecialchars($t['descripcion']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <label>Hotel:
                    <select name = "id_hotel" required>
                        <?php foreach(($hoteles ?? []) as $h): ?>
                            <option value = "<?= htmlspecialchars($h['id_hotel']) ?>"
                                <?= ((string)$r['id_hotel']===(string)$h['id_hotel'])?'selected':''?>>
                                <?= htmlspecialchars($h['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <label>Cliente (email):
                    <input type = "email" name = "email_cliente" value ="<?= htmlspecialchars($r['email_cliente'] ?? '')?>" required>        
                </label>
                <label>Número de viajeros:
                    <input type = "number" name = "num_viajeros" value ="<?= htmlspecialchars($r['num_viajeros'] ?? '')?>" required>        
                </label>
                <label>Vehículo:
                    <select name = "id_vehiculo" required>
                        <?php foreach(($vehiculos ?? []) as $v): ?>
                            <option value = "<?= htmlspecialchars($v['id_vehiculo']) ?>"
                                <?= ((string)$r['id_vehiculo']===(string)$v['id_vehiculo'])?'selected':''?>>
                                <?= htmlspecialchars($v['descripcion']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>
            </fieldset>
            <fieldset>
                <legend>Aeropuerto->Hotel</legend>
                <label>Fecha entrada: <input type="date" name="fecha_entrada" value = "<?= htmlspecialchars($r['fecha_entrada'] ?? '')?>"></label>
                <label>Hora entrada: <input type="time" name="hora_entrada" value = "<?= htmlspecialchars($r['hora_entrada'] ?? '')?>"></label>
                <label>Número vuelo entrada: <input type="text" name="numero_vuelo_entrada" value = "<?= htmlspecialchars($r['numero_vuelo_entrada'] ?? '')?>"></label>
                <label>Origen vuelo: <input type="text" name="origen_vuelo_entrada" value = "<?= htmlspecialchars($r['origen_vuelo_entrada'] ?? '')?>"></label>
            </fieldset>
            <fieldset>
                <legend>Hotel->Aeropuerto</legend>
                <label>Fecha vuelo salida: <input type="date" name="fecha_vuelo_salida" value = "<?= htmlspecialchars($r['fecha_vuelo_salida'] ?? '')?>"></label>
                <label>Hora vuelo salida: <input type="time" name="hora_vuelo_salida" value = "<?= htmlspecialchars($r['hora_vuelo_salida'] ?? '')?>"></label>
                <label>Número vuelo salida: <input type="text" name="numero_vuelo_salida" value = "<?= htmlspecialchars($r['numero_vuelo_salida'] ?? '')?>"></label>
                <label>Hora recogida hotel: <input type="time" name="hora_recogida" value = "<?= htmlspecialchars($r['hora_recogida'] ?? '')?>"></label>
            </fieldset>
            <p>
                <button type ="submit">Guardar cambios</button>
                <a href="/?url=admin/verReserva&id=<?= urlencode($r['id_reserva'] ?? '') ?>">Cancelar</a>
            </p>
        </form>   
    </body>
</html>