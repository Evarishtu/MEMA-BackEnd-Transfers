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
    <title>Información Personal</title>
    <style>
        body { font-family: Arial; background: #f7f7f7; }
        .container { width: 70%; margin: 50px auto; background: #fff; padding: 25px; border-radius: 10px; }
        label { font-weight: bold; display: block; margin-top: 10px; }
        input { width: 100%; padding: 8px; margin-top: 5px; border: 1px solid #ccc; border-radius: 5px; }
        button { margin-top: 20px; padding: 10px 20px; border: none; background: #007BFF; color: white; border-radius: 5px; cursor: pointer; }
        button:hover { background: #0056b3; }
        .disabled input { background: #eee; pointer-events: none; }
        a { text-decoration: none; color: #007BFF; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Información Personal</h1>
        <form id="infoForm" method="POST" action="/?url=viajero/actualizarInformacionPersonal" class="disabled">
            <input type="hidden" name="id_viajero" value="<?= htmlspecialchars($viajero['id_viajero']) ?>">

            <label>Nombre:</label>
            <input type="text" name="nombre" value="<?= htmlspecialchars($viajero['nombre']) ?>">

            <label>Primer apellido:</label>
            <input type="text" name="apellido1" value="<?= htmlspecialchars($viajero['apellido1']) ?>">

            <label>Segundo apellido:</label>
            <input type="text" name="apellido2" value="<?= htmlspecialchars($viajero['apellido2']) ?>">

            <label>Email:</label>
            <input type="email" name="email" value="<?= htmlspecialchars($viajero['email']) ?>" readonly>

            <label>Dirección:</label>
            <input type="text" name="direccion" value="<?= htmlspecialchars($viajero['direccion']) ?>">

            <label>Código postal:</label>
            <input type="text" name="codigoPostal" value="<?= htmlspecialchars($viajero['codigoPostal']) ?>">

            <label>País:</label>
            <input type="text" name="pais" value="<?= htmlspecialchars($viajero['pais']) ?>">

            <label>Ciudad:</label>
            <input type="text" name="ciudad" value="<?= htmlspecialchars($viajero['ciudad']) ?>">

            <button type="button" id="editarBtn">Editar</button>
            <button type="submit" id="guardarBtn" style="display:none;">Guardar</button>
        </form>
        <p><a href="/?url=viajero/dashboard">← Volver al dashboard</a></p>
    </div>

    <script>
        const form = document.getElementById('infoForm');
        const editarBtn = document.getElementById('editarBtn');
        const guardarBtn = document.getElementById('guardarBtn');

        editarBtn.addEventListener('click', () => {
            form.classList.remove('disabled');
            editarBtn.style.display = 'none';
            guardarBtn.style.display = 'inline-block';
        });
    </script>
</body>
</html>
