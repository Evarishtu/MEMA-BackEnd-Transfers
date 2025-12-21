<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Viajero registrado</title>

    <style>
        body {
            margin: 0;
            padding-top: 80px;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #3a7bd5, #00d2ff);
            color: #fff;
            text-align: center;
            min-height: 100vh;
        }

        .card {
            width: 90%;
            max-width: 450px;
            margin: auto;
            background: rgba(255, 255, 255, 0.3);
            padding: 30px;
            border-radius: 16px;
            color: #003e60;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            background: #006699;
            padding: 10px 18px;
            border-radius: 10px;
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            background: #004a80;
        }
    </style>
</head>
<body>

<div class="card">
    <h1>Viajero registrado correctamente</h1>

    <p>
        El viajero <strong>{{ $viajero->nombre }}</strong>
        con email <strong>{{ $viajero->email }}</strong> ha sido creado.
    </p>

    <a href="{{ route('hotel.dashboard') }}">Volver al inicio</a>
</div>

</body>
</html>