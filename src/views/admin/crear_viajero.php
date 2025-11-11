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

        <p><a href="/?url=admin/crearReserva">← Volver a crear reserva</a></p>
    </body>
</html>