<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
    header('Location: /?url=login/login');
    exit;
}

$vista = $vista ?? 'semana';
$fecha_base = $fecha_base ?? date('Y-m-d');

function h($s){ return htmlspecialchars((string)$s); }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calendario de trayectos</title>

    <style>
        /* ================
           ESTILOS GENERALES
        ================ */
        body {
            margin: 0;
            padding: 60px 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #3a7bd5, #00d2ff);
            color: #fff;
            min-height: 100vh;
        }

        /* ================
           TARJETA PRINCIPAL
        ================ */
        .card {
            width: 92%;
            max-width: 1100px;
            margin: auto;
            background: rgba(255, 255, 255, 0.32);
            backdrop-filter: blur(10px);
            padding: 35px;
            border-radius: 18px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.20);
            color: #003e60;
        }

        h1 {
            text-align: center;
            margin-top: 0;
            margin-bottom: 25px;
            color: #eaffff;
            font-size: 32px;
        }

        h2 {
            color: #004b6e;
            margin-top: 35px;
        }

        /* ================
           FORMULARIO SUPERIOR
        ================ */
        form {
            margin-bottom: 25px;
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        label {
            font-weight: bold;
        }

        select, input[type="date"] {
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

        /* ================
           TABLAS DEL CALENDARIO
        ================ */
        table {
            width: 100%;
            border-collapse: collapse;
            background: rgba(255,255,255,0.55);
            border-radius: 12px;
            overflow: hidden;
            margin-top: 20px;
        }

        th {
            background: rgba(0, 80, 120, 0.9);
            color: white;
            padding: 12px;
        }

        td {
            padding: 12px;
            background: rgba(255,255,255,0.85);
            vertical-align: top;
        }

        tr:nth-child(even) td {
            background: rgba(255,255,255,0.70);
        }

        /* Mes fuera de rango */
        .mes-out {
            background: rgba(230, 230, 230, 0.55) !important;
        }

        .evento {
            margin-bottom: 8px;
        }

        em {
            color: #666;
        }

    </style>
</head>

<body>

    <div class="card">

        <!-- ============================
             TÍTULO PRINCIPAL
        ============================ -->
        <h1>Calendario de trayectos</h1>

        <!-- ============================
             FORMULARIO DE FILTROS
        ============================ -->
        <form method="GET" action="/">
            <input type="hidden" name="url" value="admin/calendario">

            <label>Vista:
                <select name="vista">
                    <option value="dia"   <?= $vista==='dia'?'selected':'' ?>>Día</option>
                    <option value="semana"<?= $vista==='semana'?'selected':'' ?>>Semana</option>
                    <option value="mes"   <?= $vista==='mes'?'selected':'' ?>>Mes</option>
                </select>
            </label>

            <label>Fecha base:
                <input type="date" name="fecha" value="<?= h($fecha_base) ?>">
            </label>

            <button type="submit">Ir</button>

            <a href="/?url=admin/listarReservas">← Volver al listado</a>
        </form>

        <!-- ============================
             VISTA: DÍA
        ============================ -->
        <?php if ($vista === 'dia'): ?>

            <h2>Día: <?= h($fecha_base) ?></h2>

            <table>
                <thead>
                    <tr><th>Hora</th><th>Reserva</th></tr>
                </thead>
                <tbody>
                    <?php
                    // Filtrado de eventos del día
                    $eventosDia = $eventosDia ?? array_filter($eventos ?? [], function($e) use ($fecha_base){
                        return ($e['fecha_entrada'] === $fecha_base) 
                            || ($e['fecha_vuelo_salida'] === $fecha_base);
                    });

                    // Ordenar por hora
                    usort($eventosDia, function($a,$b){
                        $ha = $a['hora_entrada'] ?? $a['hora_vuelo_salida'] ?? '00:00';
                        $hb = $b['hora_entrada'] ?? $b['hora_vuelo_salida'] ?? '00:00';
                        return strcmp($ha,$hb);
                    });
                    ?>

                    <?php if (empty($eventosDia)): ?>
                        <tr><td colspan="2"><em>Sin eventos</em></td></tr>

                    <?php else: foreach ($eventosDia as $e): 
                        $hora = $e['hora_entrada'] ?? $e['hora_vuelo_salida'];
                        $fecha = $e['fecha_entrada'] ?? $e['fecha_vuelo_salida'];
                    ?>
                        <tr>
                            <td><?= h($hora) ?></td>
                            <td>
                                <a href="/?url=admin/verReserva&id=<?= urlencode($e['id_reserva']) ?>">
                                    <?= h($e['localizador']) ?>
                                </a>
                                — <?= h($e['tipo_descripcion']) ?>
                                — <?= h($e['hotel_nombre']) ?>
                                <small>(<?= h($fecha) ?>)</small>
                            </td>
                        </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>

        <!-- ============================
             VISTA: SEMANA
        ============================ -->
        <?php elseif ($vista === 'semana'): ?>

            <h2>Semana de <?= h($fecha_base) ?></h2>

            <table>
                <thead>
                    <tr>
                        <?php
                        // Construcción de semana
                        $diasSemana = $diasSemana ?? [];
                        if (empty($diasSemana)) {
                            $base = new DateTime($fecha_base);
                            $dow = (int)$base->format('N');
                            $base->modify('-'.($dow-1).' day');
                            for($i=0;$i<7;$i++){
                                $diasSemana[] = $base->format('Y-m-d');
                                $base->modify('+1 day');
                            }
                        }
                        ?>

                        <?php foreach ($diasSemana as $d): ?>
                            <th><?= h($d) ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <?php foreach ($diasSemana as $d): 
                            $ev = array_filter($eventos ?? [], fn($e)=>(
                                ($e['fecha_entrada']===$d) ||
                                ($e['fecha_vuelo_salida']===$d)
                            ));
                        ?>
                            <td>
                                <?php if (empty($ev)): ?>
                                    <em>Sin eventos</em>

                                <?php else: foreach ($ev as $e): 
                                    $hora = $e['hora_entrada'] ?? $e['hora_vuelo_salida'];
                                ?>
                                    <div class="evento">
                                        <a href="/?url=admin/verReserva&id=<?= urlencode($e['id_reserva']) ?>">
                                            <?= h($e['localizador']) ?>
                                        </a><br>
                                        <small><?= h($e['tipo_descripcion']) ?> · <?= h($hora) ?></small><br>
                                        <small><?= h($e['hotel_nombre']) ?></small>
                                    </div>
                                <?php endforeach; endif; ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                </tbody>
            </table>

        <!-- ============================
             VISTA: MES
        ============================ -->
        <?php else: ?>

            <h2>Mes de <?= h(substr($fecha_base,0,7)) ?></h2>

            <?php
            // Preparación de calendario mensual (42 celdas)
            $first = new DateTime(date('Y-m-01', strtotime($fecha_base)));
            $startDow = (int)$first->format('N');
            $start = clone $first;
            $start->modify('-'.($startDow-1).' day');
            $cells = [];
            for($i=0;$i<42;$i++){ 
                $cells[] = $start->format('Y-m-d'); 
                $start->modify('+1 day'); 
            }
            ?>

            <table>
                <thead>
                    <tr>
                        <th>Lun</th><th>Mar</th><th>Mié</th>
                        <th>Jue</th><th>Vie</th><th>Sáb</th><th>Dom</th>
                    </tr>
                </thead>

                <tbody>
                    <?php for($w=0;$w<6;$w++): ?>
                        <tr>
                        <?php for($d=0;$d<7;$d++): 
                            $day = $cells[$w*7+$d];
                            $isThisMonth = substr($day,0,7)===substr($fecha_base,0,7);

                            $ev = array_filter($eventos ?? [], fn($e)=>(
                                ($e['fecha_entrada']===$day) ||
                                ($e['fecha_vuelo_salida']===$day)
                            ));
                        ?>
                            <td class="<?= $isThisMonth?'':'mes-out' ?>">
                                <strong><?= h(substr($day,8,2)) ?></strong><br>

                                <?php if (empty($ev)): ?>
                                    <small><em>—</em></small>

                                <?php else: foreach ($ev as $e): 
                                    $hora = $e['hora_entrada'] ?? $e['hora_vuelo_salida'];
                                ?>
                                    <div class="evento">
                                        <a href="/?url=admin/verReserva&id=<?= urlencode($e['id_reserva']) ?>">
                                            <?= h($e['localizador']) ?>
                                        </a><br>
                                        <small><?= h($e['tipo_descripcion']) ?> · <?= h($hora) ?></small>
                                    </div>
                                <?php endforeach; endif; ?>

                            </td>
                        <?php endfor; ?>
                        </tr>
                    <?php endfor; ?>
                </tbody>
            </table>

        <?php endif; ?>

        <p style="margin-top:35px;">
            <a href="/?url=admin/listarReservas">← Volver al listado</a>
        </p>

    </div>

</body>
</html>