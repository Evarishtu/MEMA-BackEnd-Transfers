<?php 
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
    header('Location: ?url=login/login');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas</title>

    <style>
        /* ================================
           ESTILO GENERAL DE LA PÁGINA
        ================================ */
        body {
            margin: 0;
            padding: 60px 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #3a7bd5, #00d2ff);
            color: #fff;
            min-height: 100vh;
        }

        /* ================================
           TARJETA PRINCIPAL
        ================================ */
        .card {
            width: 92%;
            max-width: 1200px;
            margin: auto;
            background: rgba(255, 255, 255, 0.32);
            backdrop-filter: blur(10px);
            padding: 35px;
            border-radius: 18px;
            color: #003e60;
            box-shadow: 0 4px 12px rgba(0,0,0,0.20);
        }

        h1 {
            text-align: center;
            margin-top: 0;
            margin-bottom: 25px;
            color: #eaffff;
            font-size: 32px;
        }

        /* ================================
           FORMULARIO DE FILTROS
        ================================ */
        fieldset {
            border: none;
            background: rgba(255,255,255,0.4);
            padding: 18px;
            border-radius: 12px;
            color: #003e60;
            margin-bottom: 20px;
        }

        legend {
            font-weight: bold;
            font-size: 18px;
            color: #003e60;
        }

        label {
            display: inline-block;
            margin-right: 20px;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type="date"],
        input[type="text"],
        select {
            padding: 8px;
            border-radius: 8px;
            border: none;
            font-size: 15px;
            margin-left: 5px;
        }

        button {
            background: #007bff;
            border: none;
            padding: 10px 18px;
            border-radius: 8px;
            color: #fff;
            cursor: pointer;
            font-weight: bold;
            transition: 0.2s;
        }

        button:hover {
            background: #0056b3;
        }

        a {
            color: #003354;
            font-weight: bold;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        /* ================================
           TABLA DE RESULTADOS
        ================================ */
        .table-container {
            overflow-x: auto;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: rgba(255,255,255,0.55);
            border-radius: 12px;
            overflow: hidden;
        }

        th {
            background: rgba(0, 80, 120, 0.9);
            color: white;
            padding: 12px;
            text-align: left;
        }

        td {
            background: rgba(255,255,255,0.85);
            padding: 12px;
        }

        tr:nth-child(even) td {
            background: rgba(255,255,255,0.70);
        }

        tr:hover td {
            background: rgba(0, 150, 200, 0.20);
        }

        .acciones a {
            margin-right: 10px;
        }

    </style>
</head>

<body>

<div class="card">

    <!-- ================================
         TÍTULO PRINCIPAL
    ================================ -->
    <h1>Consultar y gestionar reservas</h1>

    <!-- ================================
         FORMULARIO DE FILTROS
    ================================ -->
    <form method="GET" action="/">
        <input type="hidden" name="url" value="admin/listarReservas">

        <fieldset>
            <legend>Filtros</legend>

            <label>
                Desde:
                <input type="date" name="desde"
                    value="<?= htmlspecialchars($filtros['desde'] ?? '') ?>">
            </label>

            <label>
                Hasta:
                <input type="date" name="hasta"
                    value="<?= htmlspecialchars($filtros['hasta'] ?? '') ?>">
            </label>

            <label>
                Tipo:
                <select name="tipo">
                    <option value="">(Todos)</option>
                    <?php foreach(($tipos_reserva ?? []) as $t): ?>
                        <option value="<?= htmlspecialchars($t['id_tipo_reserva']) ?>"
                            <?= (!empty($filtros['tipo']) && $filtros['tipo']==$t['id_tipo_reserva']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($t['Descripción']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>

            <label>
                Hotel:
                <select name="hotel">
                    <option value="">(Todos)</option>
                    <?php foreach(($hoteles ?? []) as $h): ?>
                        <option value="<?= htmlspecialchars($h['id_hotel']) ?>"
                            <?= (!empty($filtros['hotel']) && $filtros['hotel']==$h['id_hotel']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($h['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>

            <label>
                Búsqueda (localizador/email):
                <input type="text" name="q"
                    value="<?= htmlspecialchars($filtros['q'] ?? '') ?>">
            </label>

            <button type="submit">Aplicar</button>
            <a href="?url=admin/listarReservas">Limpiar</a>
        </fieldset>
    </form>

    <!-- ================================
         ENLACES A VISTAS DEL CALENDARIO
    ================================ -->
    <p>
        Vista calendario:
        <a href="?url=admin/calendario&vista=dia">Día</a>
        ·
        <a href="?url=admin/calendario&vista=semana">Semana</a>
        ·
        <a href="?url=admin/calendario&vista=mes">Mes</a>
    </p>

    <!-- ================================
         TABLA DE RESULTADOS
    ================================ -->
    <div class="table-container">
        <table cellspacing="0" cellpadding="6">
            <thead>
                <tr>
                    <th>Localizador</th>
                    <th>Fecha reserva</th>
                    <th>Tipo</th>
                    <th>Hotel</th>
                    <th>Cliente</th>
                    <th>Viajero</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                <?php if (empty($reservas)): ?>
                    <tr><td colspan="7"><em>No hay resultados</em></td></tr>

                <?php else: foreach ($reservas as $r): ?>
                    <tr>
                        <td><?= htmlspecialchars($r['localizador']) ?></td>
                        <td><?= htmlspecialchars($r['fecha_reserva']) ?></td>
                        <td><?= htmlspecialchars($r['tipo_descripcion']) ?></td>
                        <td><?= htmlspecialchars($r['hotel_nombre']) ?></td>
                        <td><?= htmlspecialchars($r['email_cliente']) ?></td>
                        <td><?= htmlspecialchars($r['num_viajeros']) ?></td>

                        <td class="acciones">
                            <a href="?url=admin/verReserva&id=<?= urlencode($r['id_reserva']) ?>">Ver</a>
                            <a href="?url=admin/editarReserva&id=<?= urlencode($r['id_reserva']) ?>">Editar</a>
                            <a href="?url=admin/cancelarReserva&id=<?= urlencode($r['id_reserva']) ?>"
                               onclick="return confirm('¿Cancelar esta reserva?');">
                                Cancelar
                            </a>
                        </td>
                    </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>

    <p style="margin-top:25px;">
        <a href="?url=admin/dashboard">⬅️ Volver al panel</a>
    </p>

</div>

</body>
</html>