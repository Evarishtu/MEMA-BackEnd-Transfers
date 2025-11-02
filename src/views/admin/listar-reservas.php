<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Reservas</title>
</head>
    <body>
        <header>
            <h1>Listado y gestión de reservas</h1>
            <nav>
                <ul>
                    <li><a href = "./dashboard.php">Volver al menú principal</a></li>
                    <li><a href = "./crear-reserva.php">Crear nueva reserva</a></li>
                </ul>
            </nav>   
        </header>
        <main>
            <?php if (!empty($reservas)): ?>
                <table cellpadding = "8" cellspacing = "0">
                    <thead>
                        <tr>
                            <th>ID Reserva</th>
                            <th>Localizador</th>
                            <th>ID hotel</th>
                            <th>ID tipo de reserva</th>
                            <th>Email cliente</th>
                            <th>Fecha de reserva</th>
                            <th>Fecha de modificación</th>
                            <th>ID destino</th>
                            <th>Fecha de llegada</th>
                            <th>Hora de llegada</th>
                            <th>Número de Vuelo de llegada</th>
                            <th>Origen de Vuelo de llegada</th>
                            <th>Hora de vuelo de salida</th> 
                            <th>Fecha de vuelo de salida</th> 
                            <th>Número de viajeros</th>
                            <th>ID vehículo</th>  
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reservas as $reserva): ?>
                            <tr>
                                <td><?= htmlspecialchars($reserva['id_reserva']) ?></td>
                                <td><?= htmlspecialchars($reserva['localizador']) ?></td>
                                <td><?= htmlspecialchars($reserva['id_hotel']) ?></td>
                                <td><?= htmlspecialchars($reserva['id_tipo_reserva']) ?></td>
                                <td><?= htmlspecialchars($reserva['email_cliente']) ?></td>
                                <td><?= htmlspecialchars($reserva['fecha_reserva']) ?></td>
                                <td><?= htmlspecialchars($reserva['fecha_modificacion']) ?></td>
                                <td><?= htmlspecialchars($reserva['id_destino']) ?></td>
                                <td><?= htmlspecialchars($reserva['fecha_entrada']) ?></td>
                                <td><?= htmlspecialchars($reserva['hora_entrada']) ?></td>
                                <td><?= htmlspecialchars($reserva['numero_vuelo_entrada']) ?></td>
                                <td><?= htmlspecialchars($reserva['origen_vuelo_entrada']) ?></td>
                                <td><?= htmlspecialchars($reserva['hora_vuelo_salida']) ?></td>
                                <td><?= htmlspecialchars($reserva['fecha_vuelo_salida']) ?></td>
                                <td><?= htmlspecialchars($reserva['num_viajeros']) ?></td>
                                <td><?= htmlspecialchars($reserva['id_vehiculo']) ?></td>
                                <td>
                                    <form method = "POST" action = "editar_reserva.php" style = "display:inline;">
                                        <input type = "hidden" name = "id_reserva" value = "<?= $reserva['id_reserva'] ?>">
                                        <button type = "submit">Editar</button>
                                    </form>
                                    <form method = "POST" action = "eliminar_reserva.php" style = "display:inline;">
                                        <input type = "hidden" name = "id_reserva" value = <?= $reserva['id_reserva'] ?>>
                                        <button type = "submit">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No hay reservas registradas</p>
            <?php endif ?>
        </main>
    </body>
</html>