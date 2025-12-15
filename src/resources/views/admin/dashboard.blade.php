<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Panel de Administración</title>

    <style>
      body {
        margin: 0;
        font-family: "Arial", sans-serif;
        background: linear-gradient(135deg, #3a7bd5, #00d2ff);
        color: #fff;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        padding-top: 100px;
        min-height: 100vh;
    }
    .navbar {
        background: #ffffff;
        padding: 15px 40px;
        border-bottom-left-radius: 20px;
        border-bottom-right-radius: 20px;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    .navbar-title {
        font-size: 18px;
        font-weight: bold;
        color: #1f2937;
    }
     .navbar button.logout-btn {
        background: #ff4d4d;
        padding: 8px 14px;
        border-radius: 10px;
        color: #fff;
        font-weight: bold;
        text-decoration: none;
        transition: 0.3s;
        cursor: pointer;
    }

    .navbar button.logout-btn:hover {
        background: #e60000;
    }
    .container {
        background: rgba(0, 0, 0, 0.25);
        padding: 40px;
        border-radius: 20px;
        width: 450px;
        backdrop-filter: blur(6px);
        text-align: center;
    }

    h1 {
        margin-top: 0;
        margin-bottom: 25px;
        font-size: 30px;
        font-weight: bold;
    }
    .menu a {
        display: block;
        background: #ffffff33;
        padding: 14px;
        border-radius: 12px;
        margin: 12px 0;
        color: #e8f6ff;
        font-size: 18px;
        font-weight: bold;
        text-decoration: none;
        transition: 0.25s;
        backdrop-filter: blur(4px);
    }

    .menu a:hover {
        background: #ffffff55;
    }
    </style>
</head>

<body>
    <div class="navbar">
        <div class="navbar-title">🛠️ Panel de administraddor</div>
        {{-- Botón de logout --}}
        <form method="POST" action="{{ route('admin.logout') }}">
        @csrf
        <button type="submit" class="logout-btn">Cerrar sesión</button>
        </form>
    </div>
    <div class="container">

        {{-- Nombre del viajero --}}
        <h1>Bienvenid@, {{ $admin->nombre ?? 'Admin' }} 👋</h1>

        <div class = "menu">
            <a href="{{ route('admin.calendario') }}">📅 Calendario de reservas</a>
            <a href="{{ route('admin.reservas.crear') }}">🆕 Crear nueva reserva</a>
            <a href="{{ route('admin.reservas.index') }}">📋 Consultar y gestionar reservas</a>
            <a href="{{ route('admin.comisiones') }}">💰 Comisiones por hotel</a>
            <a href="{{ route('admin.hotel.crear') }}">🏨 Dar de alta usuario corporativo</a>
            <a href="{{ route('admin.info') }}">👥 Información personal</a>
        </div>
    </div>

</body>
</html>

