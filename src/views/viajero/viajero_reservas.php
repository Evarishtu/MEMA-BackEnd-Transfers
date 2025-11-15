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
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #3a7bd5, #00d2ff);
            padding-top: 120px;
            padding-bottom: 60px;
            color: #fff;
            min-height: 100vh;
        }

        .card {
            width: 92%;
            max-width: 1100px;
            margin: auto;
            background: rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
            border-radius: 18px;
            padding: 35px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            color: #fff;
        }

        h1 {
            text-align: center;
            margin-top: 0;
            margin-bottom: 30px;
            font-size: 32px;
        }

        h2 {
            text-align: center;
            margin-bottom: 10px;
            margin-top: 40px;
            font-size: 24px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            background: rgba(255, 255, 255, 0.5);
        }

        th, td {
            padding: 12px;
            text-align: center;
            color: #003b63;
            border-bottom: 1px solid rgba(0,0,0,0.2);
            font-weight: bold;
        }

        th {
            background-color: rgba(0, 80, 160, 0.8);
            color: #fff;
            border: none;
        }

        tr:nth-child(even) td {
            background-color: rgba(255, 255, 255, 0.35);
        }

        .no-reservas {
            text-align: center;
            font-size: 18px;
            margin-top: 10px;
        }

        a.back {
            display: block;
            text-align: center;
            margin-top: 35px;
            text-decoration: none;
            color: #e5f3ff;
            font-size: 18px;
            font-weight: bold;
        }

        a.back:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

<div class="card">

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
            <p class="no-reservas">Aún no hay reservas creadas por ti.</p>
        <?php endif; ?>
    </div>

    <!-- ====================== -->
    <!-- RESERVAS CREADAS POR EL ADMINISTRADOR -->
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
            <p class="no-reservas">Aún no hay reservas creadas por el administrador.</p>
        <?php endif; ?>
    </div>

    <a class="back" href="/?url=viajero/dashboard">← Volver al dashboard</a>

</div>

</body>
</html>