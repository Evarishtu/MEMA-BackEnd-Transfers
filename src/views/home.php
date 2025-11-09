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
    <title>Isla Transfers - Inicio</title>
</head>
    <body>
        <header>
            <h1>Bienvenido a Isla Transfers</h1>
        </header>
        <main>
            <?php if (isset($_SESSION['rol'])): ?>
                <p>Hola, <?= htmlspecialchars($_SESSION['user_nombre'] ?? 'usuario') ?>.</p>
                <p><a href="/?url=login/logout">Cerrar sesión</a></p>

                <?php if ($_SESSION['rol'] === 'administrador'): ?>
                    <a href="/?url=admin/dashboard">Ir al panel de administración</a>
                <?php else: ?>
                    <a href="/?url=reservas/misReservas">Ver mis reservas</a>
                <?php endif; ?>

            <?php else: ?>
                <nav>
                    <ul>
                        <li><a href="/?url=login/login">Iniciar sesión</a></li>
                        <li><a href="/?url=registro/registrar">Registrarse</a></li>
                    </ul>
                </nav>
            <?php endif; ?>
        </main>

        <footer>
            <p>&copy; <?= date('Y') ?> Isla Transfers</p>
        </footer>
    </body>
</html>

