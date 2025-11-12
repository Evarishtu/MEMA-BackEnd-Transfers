<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Vehículos</title>
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

<h2>🚗 Gestión de Vehículos</h2>

<p>
    <a href="/?url=vehiculo/crearvehiculo" class="btn">➕ Nuevo vehículo</a>
</p>

<?php if (empty($vehiculos)): ?>
    <p>No hay vehículos registrados todavía.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>ID Vehículo</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($vehiculos as $vehiculo): ?>
                <tr>
                    <td><?= htmlspecialchars($vehiculo['id_vehiculo']) ?></td>
                    <td><?= htmlspecialchars($vehiculo['descripcion']) ?></td>
                    <td class="acciones">
                        <a href="/?url=vehiculo/editarvehiculo&id=<?= $vehiculo['id_vehiculo'] ?>">✏️ Editar</a>
                        <a href="/?url=vehiculo/eliminarvehiculo&id=<?= $vehiculo['id_vehiculo'] ?>"
                           onclick="return confirm('¿Seguro que quieres eliminar este vehículo?');">🗑️ Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

</body>
</html>
