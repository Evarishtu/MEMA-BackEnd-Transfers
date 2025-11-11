<?php 
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
    header('Location: /?url=login/login'); exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas</title>
</head>
<body>
    <h1>Consultar y gestionar reservas</h1>
    <form method = "GET" action = "/">
        <input type = "hidden" name = "url" value = "admin/listarReservas">
        <fieldset>
            <legend>Filtros</legend>
            <label>Desde: <input type = "date" name = "desde" value = "<?= htmlspecialchars($filtros['desde'] ?? '')?>"></label>
            <label>Hasta: <input type = "date" name = "hasta" value = "<?= htmlspecialchars($filtros['hasta'] ?? '')?>"></label>
            <label>Tipo:
                <select name = "tipo">
                    <option value = "">(Todos)</option>
                     <?php foreach(($tipos_reserva ?? []) as $t): ?>
                        <option value = "<?= htmlspecialchars($t['id_tipo_reserva']) ?>"
                            <?= (isset($filtros['tipo']) && $filtros['tipo']==$t['id_tipo_reserva'])?'selected' : ''?>>
                            <?= htmlspecialchars($t['Descripción']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label>Hotel:
                <select name = "hotel">
                    <option value = "">(Todos)</option>
                    <?php foreach(($hoteles ?? []) as $h): ?>
                        <option value = "<?= htmlspecialchars($h['id_hotel']) ?>"
                            <?= (isset($filtros['hotel']) && $filtros['hotel']==$h['id_hotel'])?'selected':''?>>
                            <?= htmlspecialchars($h['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label>Búsqueda (localizador/email):
                <input type = "text" name = "q" value = "<? htmlspecialchars($filtros['q'] ?? '') ?>">
            </label>
            <button type = "submit">Aplicar</button>
            <a href = "/?url=admin/listarReservas">Limpiar</a>     
        </fieldset>
    </form>
    <p>
        Vista calendario:
        <a href="/?url=admin/calendario&vista=dia">Día</a>
        <a href="/?url=admin/calendario&vista=semana">Semana</a>
        <a href="/?url=admin/calendario&vista=mes">Mes</a>
    </p>
    <div style="overflow-x:auto;">
        <table cellspacing = "0" cellpadding = "6">
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
                    <tr><td colspan = "7">No hay resultados</td></tr>
                <?php else: foreach ($reservas as $r): ?>
                    <tr>
                        <td><?= htmlspecialchars($r['localizador']) ?></td>
                        <td><?= htmlspecialchars($r['fecha_reserva']) ?></td>
                        <td><?= htmlspecialchars($r['tipo_descripcion']) ?></td>
                        <td><?= htmlspecialchars($r['hotel_nombre']) ?></td>
                        <td><?= htmlspecialchars($r['email_cliente']) ?></td>
                        <td><?= htmlspecialchars($r['num_viajeros']) ?></td>
                        <td>
                            <a href="/?url=admin/verReserva&id=<?= urlencode($r['id_reserva'])?>">Ver</a>
                            <a href="/?url=admin/editarReserva&id=<?= urlencode($r['id_reserva'])?>">Editar</a>
                            <a href="/?url=admin/cancelarReserva&id=<?= urlencode($r['id_reserva'])?>"
                                onclick = "return confirm('¿Cancelar esta reserva?');">Cancelar</a>
                        </td>
                    </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
    <p><a href="/?url=admin/dashboard"><-Volver al panel</a></p>
</body>
</html>