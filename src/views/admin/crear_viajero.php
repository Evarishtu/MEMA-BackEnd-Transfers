<?php 
if (session_status() === PHP_SESSION_NONE){
    session_start();
}

if(!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador'){
    header('Location: /?url=login/login');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar nuevo cliente</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 60px 0;
            background: linear-gradient(135deg, #3a7bd5, #00d2ff);
            color: #fff;
            min-height: 100vh;
        }

        .card {
            width: 90%;
            max-width: 450px;
            margin: auto;
            background: rgba(255,255,255,0.32);
            backdrop-filter: blur(10px);
            padding: 35px;
            border-radius: 16px;
            color: #003e60;
            box-shadow: 0 4px 12px rgba(0,0,0,0.20);
        }

        h2 {
            text-align: center;
            margin-top: 0;
            color: #eaffff;
        }

        form {
            margin-top: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 6px;
        }

        input {
            width: 100%;
            padding: 9px;
            margin-bottom: 14px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
        }

        button {
            width: 100%;
            background: #006bb3;
            color: #fff;
            padding: 12px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            margin-top: 10px;
            font-size: 15px;
        }

        button:hover {
            background: #005c99;
        }

        a {
            color: #003354;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        .volver {
            text-align: center;
            margin-top: 25px;
        }
    </style>
</head>

<body>

<div class="card">
    <h2>Registrar nuevo cliente</h2>

    <form method="POST" action="/?url=admin/guardarViajero">
        <input type="hidden" name="tipo_reserva" value="<?= htmlspecialchars($_GET['tipo_reserva'] ?? '') ?>">

        <label>Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($_GET['email'] ?? '') ?>" required>

        <label>Nombre:</label>
        <input type="text" name="nombre" required>

        <label>Primer apellido:</label>
        <input type="text" name="apellido1" required>

        <label>Segundo apellido:</label>
        <input type="text" name="apellido2">

        <label>Dirección:</label>
        <input type="text" name="direccion" required>

        <label>Código postal:</label>
        <input type="text" name="codigoPostal" required>

        <label>País:</label>
        <input type="text" name="pais" required>

        <label>Ciudad:</label>
        <input type="text" name="ciudad" required>

        <button type="submit">Guardar cliente</button>
    </form>

    <p class="volver">
        <a href="/?url=admin/crearReserva">← Volver a crear reserva</a>
    </p>
</div>

</body>
</html>