<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Hoteles</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f9f9f9;
        }
        h2 {
            margin-bottom: 20px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            background: #fff;
            box-shadow: 0 0 4px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        th {
            background: #f4f4f4;
        }
        a.btn {
            display: inline-block;
            padding: 6px 10px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        a.btn:hover {
            background-color: #0056b3;
        }
        .acciones a {
            margin-right: 10px;
            color: #007bff;
            text-decoration: none;
        }
        .acciones a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<h2>🏨 Gestión de Hoteles</h2>

<p>
    <a href="/?url=hotel/listarZonas" class="btn">➕ Nuevo hotel</a>
</p>

<?php if (empty($hoteles)): ?>
    <p>No hay hoteles registrados todavía.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>ID Hotel</th>
                <th>Nombre del Hotel</th>
                <th>Zona</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($hoteles as $hotel): ?>
                <tr>
                    <td><?= htmlspecialchars($hotel['id_hotel']) ?></td>
                    <td><?= htmlspecialchars($hotel['nombre_hotel']) ?></td>
                    <td><?= htmlspecialchars($hotel['nombre_zona'] ?? 'Sin zona asignada') ?></td>
                    <td class="acciones">
                        <a href="/?url=hotel/listarZonas&id=<?= $hotel['id_hotel'] ?>">✏️ Editar</a>
                        <a href="/?url=hotel/eliminarHotel&id=<?= $hotel['id_hotel'] ?>"
                           onclick="return confirm('¿Seguro que quieres eliminar este hotel?');">🗑️ Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

</body>
</html>
