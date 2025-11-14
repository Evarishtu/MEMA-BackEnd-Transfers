<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Protección por rol
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
    header('Location: /?url=login/login');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información Personal del Administrador</title>
    <style>
        body { font-family: Arial; background: #f7f7f7; margin: 0; padding: 0; }
        .container { width: 70%; margin: 50px auto; background: #fff; padding: 25px; border-radius: 10px; }
        label { font-weight: bold; display: block; margin-top: 10px; }
        input { width: 100%; padding: 8px; margin-top: 5px; border: 1px solid #ccc; border-radius: 5px; }
        button { margin-top: 20px; padding: 10px 20px; border: none; background: #007BFF; color: white; border-radius: 5px; cursor: pointer; }
        button:hover { background: #0056b3; }
        .disabled input { background: #eee; pointer-events: none; }
        .toggle-btn {
            margin-top: 5px; 
            padding: 5px 10px;
            background: #6c757d;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            border: none;
        }
        .toggle-btn:hover { background: #565e64; }
        a { text-decoration: none; color: #007BFF; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Información Personal del Administrador</h1>

        <form id="infoForm" method="POST" action="/?url=admin/actualizarInformacionPersonal" class="disabled">

            <input type="hidden" name="id_admin" 
                   value="<?= htmlspecialchars($admin['id_admin'] ?? '', ENT_QUOTES) ?>">

            <label>Nombre:</label>
            <input type="text" name="nombre" 
                   value="<?= htmlspecialchars($admin['nombre'] ?? '', ENT_QUOTES) ?>">

            <label>Email:</label>
            <input type="email" name="email" 
                   value="<?= htmlspecialchars($admin['email'] ?? '', ENT_QUOTES) ?>" readonly>

            <label>Contraseña:</label>
            <input type="password" id="passwordField" name="password"
                   value="<?= htmlspecialchars($admin['password'] ?? '', ENT_QUOTES) ?>" disabled>

            <button type="button" class="toggle-btn" id="togglePassword" disabled>
                Mostrar contraseña
            </button>

            <button type="button" id="editarBtn">Editar</button>
            <button type="submit" id="guardarBtn" style="display:none;">Guardar</button>

        </form>

        <p><a href="/?url=admin/dashboard">← Volver al panel</a></p>
    </div>

    <script>
        const form = document.getElementById('infoForm');
        const editarBtn = document.getElementById('editarBtn');
        const guardarBtn = document.getElementById('guardarBtn');

        const passwordField = document.getElementById('passwordField');
        const togglePassword = document.getElementById('togglePassword');

        // Activar edición
        editarBtn.addEventListener('click', () => {
            form.classList.remove('disabled');
            passwordField.disabled = false;
            togglePassword.disabled = false;

            editarBtn.style.display = 'none';
            guardarBtn.style.display = 'inline-block';
        });

        // Mostrar / Ocultar contraseña
        togglePassword.addEventListener('click', () => {
            if (passwordField.type === "password") {
                passwordField.type = "text";
                togglePassword.textContent = "Ocultar contraseña";
            } else {
                passwordField.type = "password";
                togglePassword.textContent = "Mostrar contraseña";
            }
        });
    </script>
</body>
</html>
