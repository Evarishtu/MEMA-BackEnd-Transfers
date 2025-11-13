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
            margin: 40px;
            line-height: 1.6;
        }

        h2 {
            color: #007bff;
            margin-bottom: 20px;
        }

        form {
            max-width: 400px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        button {
            background-color: #007bff;
            color: white;
            padding: 10px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        button:hover {
            background-color: #0056b3;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .volver {
            margin-top: 15px;
            display: inline-block;
        }
    </style>
</head>
    <body>
        <h2>Registrar nuevo cliente</h2>

        <form method="POST" action="/?url=admin/guardarViajero">
            <input type="hidden" name="tipo_reserva" value="<?= htmlspecialchars($_GET['tipo_reserva'] ?? '') ?>">

            <label>Email:</label><br>
            <input type="email" name="email" value="<?= htmlspecialchars($_GET['email'] ?? '') ?>" required><br><br>

            <label>Nombre:</label><br>
            <input type="text" name="nombre" required><br><br>

            <label>Primer apellido:</label><br>
            <input type="text" name="apellido1" required><br><br>

            <label>Segundo apellido:</label><br>
            <input type="text" name="apellido2"><br><br>

            <label>Dirección:</label><br>
            <input type="text" name="direccion" required><br><br>

            <label>Código postal:</label><br>
            <input type="text" name="codigoPostal" required><br><br>

            <label>País:</label><br>
            <input type="text" name="pais" required><br><br>

            <label>Ciudad:</label><br>
            <input type="text" name="ciudad" required><br><br>

            <button type="submit">Guardar cliente</button>
        </form>

        <p><a href="/?url=admin/crearReserva">⬅️ Volver a crear reserva</a></p>
    </body>
</html>