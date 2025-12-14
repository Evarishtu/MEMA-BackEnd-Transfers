<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Hotel</title>
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
            margin: 0;
        }

        ul li {
            position: relative;
            background: rgba(255, 255, 255, 0.45);
            padding: 16px;
            margin: 12px 0;
            border-radius: 10px;
            transition: 0.2s;

            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Barra decorativa SIN afectar centrado */
        ul li::before {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            width: 4px;
            height: 100%;
            background: #004a80;
            border-radius: 10px 0 0 10px;
        }

        ul li:hover {
            background: rgba(255, 255, 255, 0.60);
        }

        ul li a {
            text-decoration: none;
            color: #003b63;
            font-weight: bold;
            font-size: 17px;

            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;

            width: 100%;
            text-align: center;
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
        <h1>🏨 Panel del Corporativo</h1>
        <p>Bienvenido, <strong>{{ $hotel->nombre }}</strong></p>

        <ul>
            <li><a href="{{route('hotel.reservas.crear')}}">🆕 Crear reserva</a></li>
            <li><a href="{{route('hotel.reservas.listar')}}">📋 Reservas realizadas</a></li>
            <li><a href="{{route('hotel.comisiones')}}">💰 Comisiones mensuales</a></li>
        </ul>
        <div class="logout">
            <form method="POST" action="{{ route('hotel.logout') }}">
                @csrf
                <button>Cerrar sesión</button>
            </form>
        </div>
    </div>
</body>
</html>