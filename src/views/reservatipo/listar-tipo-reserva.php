<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de tipo de reservas</title>
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

<h2>📍 Gestión de tipo de reservas</h2>

<p>
    <a href="/?url=reservatipo/create" class="btn">➕ Nuevo tipo de reserva</a>
</p>

<?php if (empty($reservatipo)): ?>
    <p>Todavía no hay tipo de reservas registrado.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>ID tipo de reserva</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reservatipo as $reservatipo): ?>
                <tr>
                    <td><?= htmlspecialchars($reservatipo['id_tipo_reserva']) ?></td>
                    <td><?= htmlspecialchars($reservatipo['descripcion']) ?></td>
                    <td class="acciones">
                        <a href="/?url=reservatipo/edit&id=<?= $reservatipo['id_tipo_reserva'] ?>">✏️ Editar</a>
                        <a href="/?url=reservatipo/delete&id=<?= $reservatipo['id_tipo_reserva'] ?>"
                           onclick="return confirm('¿Seguro que quieres eliminar esta tipo de reserva?');">🗑️ Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

</body>
</html>