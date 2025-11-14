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
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 60px 0;
            background: linear-gradient(135deg, #3a7bd5, #00d2ff);
            min-height: 100vh;
        }

        .card {
            width: 90%;
            max-width: 650px;
            margin: auto;
            background: rgba(255,255,255,0.35);
            backdrop-filter: blur(10px);
            padding: 35px;
            border-radius: 16px;
            color: #003e60;
        }

        h1 {
            text-align: center;
            color: white;
            margin-bottom: 25px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }

        input {
            width: 100%;
            padding: 9px;
            margin-top: 5px;
            border: 1px solid #bcdff5;
            border-radius: 6px;
            background: rgba(255,255,255,0.8);
        }

        .disabled input {
            background: rgba(200,200,200,0.4);
            pointer-events: none;
        }

        button {
            margin-top: 18px;
            padding: 10px 18px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }

        #editarBtn {
            background: #004f7c;
            color: white;
        }

        #guardarBtn {
            background: #007bff;
            color: white;
        }

        #togglePassword {
            background: #6c757d;
            color: white;
            font-size: 14px;
            margin-top: 5px;
        }

        a {
            text-decoration: none;
            font-weight: bold;
            color: #004f7c;
        }
    </style>
</head>

<body>

<div class="card">

    <h1>Información Personal del Administrador</h1>

    <form id="infoForm" method="POST" action="/?url=admin/actualizarInformacionPersonal" class="disabled">

        <input type="hidden" name="id_admin" 
               value="<?= htmlspecialchars($admin['id_admin'] ?? '') ?>">

        <label>Nombre:</label>
        <input type="text" name="nombre" 
               value="<?= htmlspecialchars($admin['nombre'] ?? '') ?>">

        <label>Email:</label>
        <input type="email" name="email" 
               value="<?= htmlspecialchars($admin['email'] ?? '') ?>" readonly>

        <label>Contraseña:</label>
        <input type="password" id="passwordField" name="password"
               value="<?= htmlspecialchars($admin['password'] ?? '') ?>" disabled>

        <button type="button" id="togglePassword" disabled>Mostrar contraseña</button>

        <button type="button" id="editarBtn">Editar</button>
        <button type="submit" id="guardarBtn" style="display:none;">Guardar</button>

    </form>

    <p style="margin-top:20px; text-align:center;">
        <a href="/?url=admin/dashboard">← Volver al panel</a>
    </p>

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