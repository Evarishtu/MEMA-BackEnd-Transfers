<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
  header('Location: /?url=login/login'); exit;
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
</head>
<body>
  <h1>Calendario de trayectos</h1>

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

  <?php if ($vista === 'dia'): ?>
    <h2>Día: <?= h($fecha_base) ?></h2>
    <table cellspacing="0" cellpadding="6">
      <thead><tr><th>Hora</th><th>Reserva</th></tr></thead>
      <tbody>
        <?php
          // Events del día: el controlador puede pasar $eventosDia ya filtrados
          $eventosDia = $eventosDia ?? array_filter($eventos ?? [], function($e) use ($fecha_base){
            return ($e['fecha_entrada'] === $fecha_base) || ($e['fecha_vuelo_salida'] === $fecha_base);
          });
          // Orden por hora:
          usort($eventosDia, function($a,$b){
            $ha = $a['hora_entrada'] ?? $a['hora_vuelo_salida'] ?? '00:00:00';
            $hb = $b['hora_entrada'] ?? $b['hora_vuelo_salida'] ?? '00:00:00';
            return strcmp($ha,$hb);
          });
        ?>
        <?php if (empty($eventosDia)): ?>
          <tr><td colspan="2">Sin eventos</td></tr>
        <?php else: foreach ($eventosDia as $e): 
              $hora = $e['hora_entrada'] ?? $e['hora_vuelo_salida'] ?? '';
              $fecha = $e['fecha_entrada'] ?? $e['fecha_vuelo_salida'] ?? '';
        ?>
          <tr>
            <td><?= h($hora) ?></td>
            <td>
              <a href="/?url=admin/verReserva&id=<?= urlencode($e['id_reserva']) ?>">
                <?= h($e['localizador']) ?>
              </a>
              — <?= h($e['tipo_descripcion'] ?? '') ?> — <?= h($e['hotel_nombre'] ?? '') ?> — <?= h($e['email_cliente'] ?? '') ?>
              <small>(<?= h($fecha) ?>)</small>
            </td>
          </tr>
        <?php endforeach; endif; ?>
      </tbody>
    </table>

  <?php elseif ($vista === 'semana'): ?>
    <h2>Semana de <?= h($fecha_base) ?></h2>
    <table cellspacing="0" cellpadding="6">
      <thead>
        <tr>
          <?php
            // El controlador idealmente pasa $diasSemana = [ 'YYYY-MM-DD', ... x7 ]
            // Si no, construimos una semana simple (L-D) a partir de fecha_base (asumida lunes)
            $diasSemana = $diasSemana ?? []; 
            if (empty($diasSemana)) {
              $base = new DateTime($fecha_base);
              $dow = (int)$base->format('N'); // 1=Lunes .. 7=Domingo
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
            $ev = array_filter($eventos ?? [], function($e) use ($d){
              return ($e['fecha_entrada'] === $d) || ($e['fecha_vuelo_salida'] === $d);
            });
          ?>
            <td valign="top">
              <?php if (empty($ev)): ?>
                <em>Sin eventos</em>
              <?php else: foreach ($ev as $e): 
                $hora = $e['hora_entrada'] ?? $e['hora_vuelo_salida'] ?? '';
              ?>
                <div style="margin-bottom:8px;">
                  <a href="/?url=admin/verReserva&id=<?= urlencode($e['id_reserva']) ?>">
                    <?= h($e['localizador']) ?>
                  </a>
                  <br>
                  <small><?= h($e['tipo_descripcion'] ?? '') ?> · <?= h($hora) ?></small><br>
                  <small><?= h($e['hotel_nombre'] ?? '') ?></small>
                </div>
              <?php endforeach; endif; ?>
            </td>
          <?php endforeach; ?>
        </tr>
      </tbody>
    </table>

  <?php else: /* mes */ ?>
    <h2>Mes de <?= h(substr($fecha_base,0,7)) ?></h2>
    <?php
      // El controlador puede pasar $diasMes como matriz 6x7; si no, hacemos un grid básico.
      // Generamos calendario mensual simple:
      $first = new DateTime(date('Y-m-01', strtotime($fecha_base)));
      $startDow = (int)$first->format('N'); // 1..7 (L..D)
      $start = clone $first;
      $start->modify('-'.($startDow-1).' day'); // Lunes de la semana que arranca el mes
      $cells = [];
      for($i=0;$i<42;$i++){ $cells[] = $start->format('Y-m-d'); $start->modify('+1 day'); }
    ?>
    <table cellspacing="0" cellpadding="6">
      <thead>
        <tr>
          <th>Lun</th><th>Mar</th><th>Mié</th><th>Jue</th><th>Vie</th><th>Sáb</th><th>Dom</th>
        </tr>
      </thead>
      <tbody>
        <?php for($w=0;$w<6;$w++): ?>
          <tr>
          <?php for($d=0;$d<7;$d++): 
              $day = $cells[$w*7+$d];
              $isThisMonth = (substr($day,0,7)===substr($fecha_base,0,7));
              $ev = array_filter($eventos ?? [], function($e) use ($day){
                return ($e['fecha_entrada'] === $day) || ($e['fecha_vuelo_salida'] === $day);
              });
          ?>
            <td valign="top" style="<?= $isThisMonth?'':'background:#f5f5f5' ?>">
              <strong><?= h(substr($day,8,2)) ?></strong>
              <div>
                <?php if (empty($ev)): ?>
                  <div><small><em>—</em></small></div>
                <?php else: foreach ($ev as $e): 
                  $hora = $e['hora_entrada'] ?? $e['hora_vuelo_salida'] ?? '';
                ?>
                  <div style="margin:6px 0;">
                    <a href="/?url=admin/verReserva&id=<?= urlencode($e['id_reserva']) ?>">
                      <?= h($e['localizador']) ?>
                    </a>
                    <br><small><?= h($e['tipo_descripcion'] ?? '') ?> · <?= h($hora) ?></small>
                  </div>
                <?php endforeach; endif; ?>
              </div>
            </td>
          <?php endfor; ?>
          </tr>
        <?php endfor; ?>
      </tbody>
    </table>
  <?php endif; ?>

  <p><a href="/?url=admin/listarReservas">← Volver al listado</a></p>
</body>
</html>