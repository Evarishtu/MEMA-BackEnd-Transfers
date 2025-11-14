<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Reservas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f7f7;
            color: #333;
        }
        .container {
            width: 90%;
            margin: 40px auto;
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1, h2 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }
        th {
            background: #007BFF;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .section {
            margin-bottom: 50px;
        }
        a {
            text-decoration: none;
            color: #007BFF;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Reservas de <?= htmlspecialchars($_SESSION['user_nombre']) ?></h1>

    <!-- ====================== -->
    <!-- RESERVAS CREADAS POR EL VIAJERO -->
    <!-- ====================== -->
    <div class="section">
        <h2>✈️ Reservas creadas por <?= htmlspecialchars($_SESSION['user_nombre']) ?></h2>
        <?php if (!empty($reservasViajero)) : ?>
            <table>
                <thead>
                    <tr>
                        <th>Localizador</th>
                        <th>Fecha Reserva</th>
                        <th>Tipo de Reserva</th>
                        <th>Hotel / Destino</th>
                        <th>Zona</th>
                        <th>Número de Viajeros</th>
                        <th>Vehículo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservasViajero as $r): ?>
                        <tr>
                            <td><?= htmlspecialchars($r['localizador']) ?></td>
                            <td><?= htmlspecialchars($r['fecha_reserva']) ?></td>
                            <td><?= htmlspecialchars($r['TipoReservaDesc'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($r['HotelDesc'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($r['ZonaDesc'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($r['num_viajeros'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($r['VehiculoDesc'] ?? '-') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p style="text-align:center;">Aun no hay reservas creadas por ti.</p>
        <?php endif; ?>
    </div>

    <!-- ====================== -->
    <!-- RESERVAS CREADAS POR ADMIN -->
    <!-- ====================== -->
    <div class="section">
        <h2>🧾 Reservas creadas por el administrador</h2>
        <?php if (!empty($reservasAdmin)) : ?>
            <table>
                <thead>
                    <tr>
                        <th>Localizador</th>
                        <th>Fecha Reserva</th>
                        <th>Tipo de Reserva</th>
                        <th>Hotel / Destino</th>
                        <th>Zona</th>
                        <th>Número de Viajeros</th>
                        <th>Vehículo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservasAdmin as $r): ?>
                        <tr>
                            <td><?= htmlspecialchars($r['localizador']) ?></td>
                            <td><?= htmlspecialchars($r['fecha_reserva']) ?></td>
                            <td><?= htmlspecialchars($r['TipoReservaDesc'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($r['HotelDesc'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($r['ZonaDesc'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($r['num_viajeros'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($r['VehiculoDesc'] ?? '-') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p style="text-align:center;">Aun no hay reservas creadas por el administrador.</p>
        <?php endif; ?>
    </div>

    <p style="text-align:center;"><a href="/?url=viajero/dashboard">← Volver al dashboard</a></p>
</div>
</body>
</html>
