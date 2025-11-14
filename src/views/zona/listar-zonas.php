<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Zonas</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: left; }
        th { background-color: #f4f4f4; }
        a.btn {
            display: inline-block;
            padding: 6px 10px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        a.btn:hover { background-color: #0056b3; }
        .acciones a {
            margin-right: 10px;
            color: #007bff;
            text-decoration: none;
        }
        .acciones a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<p><a href="/" class="btn">🏠 Volver al inicio</a></p>

<h2>📍 Gestión de Zonas</h2>

<p>
    <a href="/?url=zona/create" class="btn">➕ Nueva Zona</a>
</p>

<?php if (empty($zonas)): ?>
    <p>No hay zonas registradas todavía.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>ID Zona</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($zonas as $zona): ?>
                <tr>
                    <td><?= htmlspecialchars($zona['id_zona']) ?></td>
                    <td><?= htmlspecialchars($zona['descripcion']) ?></td>
                    <td class="acciones">
                        <a href="/?url=zona/edit&id=<?= $zona['id_zona'] ?>">✏️ Editar</a>
                        <a href="/?url=zona/delete&id=<?= $zona['id_zona'] ?>"
                           onclick="return confirm('¿Seguro que quieres eliminar esta zona?');">🗑️ Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

</body>
</html>