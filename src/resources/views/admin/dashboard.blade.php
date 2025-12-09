<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Panel de Administración</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #3a7bd5, #00d2ff);
            color: #fff;
            min-height: 100vh;
            padding-top: 120px;
        }

        .card {
            width: 92%;
            max-width: 750px;
            margin: auto;
            background: rgba(255, 255, 255, 0.30);
            backdrop-filter: blur(8px);
            padding: 35px;
            border-radius: 18px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        h1 {
            margin-top: 0;
            margin-bottom: 30px;
            font-size: 30px;
            color: #e7ffe7;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        ul li {
            background: rgba(255, 255, 255, 0.45);
            padding: 14px;
            margin: 12px 0;
            border-radius: 10px;
            border-left: 4px solid #004a80;
            transition: 0.2s;
        }

        ul li:hover {
            background: rgba(255, 255, 255, 0.60);
        }

        a {
            text-decoration: none;
            color: #003b63;
            font-weight: bold;
            font-size: 17px;
        }

        .logout {
            margin-top: 35px;
        }

        .logout button {
            background: #004a80;
            color: white;
            padding: 10px 18px;
            border-radius: 10px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            transition: 0.2s;
        }

        .logout button:hover {
            background: #00345a;
        }
    </style>
</head>

<body>

    <div class="card">

        <h1>
            Panel de Administración — Bienvenido, 
            {{ Auth::guard('admin')->user()->nombre }}
        </h1>

        <ul>
            <li><a href="#">📅 Calendario de reservas</a></li>
            <li><a href="#">🆕 Crear nueva reserva</a></li>
            <li><a href="{{ route('admin.reservas.index') }}">📋 Consultar y gestionar reservas</a></li>
            <li><a href="{{ route('admin.info') }}">👥 Información personal</a></li>
        </ul>

        <div class="logout">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit">🚪 Cerrar sesión</button>
            </form>
        </div>

    </div>

</body>
</html>
