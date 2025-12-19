<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reserva confirmada</title>

    <style>
        body {
            margin:0; padding:60px 0;
            font-family:Arial;
            background:linear-gradient(135deg,#3a7bd5,#00d2ff);
            color:#fff;
            min-height:100vh;
        }

        .card {
            width:90%; max-width:650px;
            margin:auto;
            background:rgba(255,255,255,0.32);
            backdrop-filter:blur(10px);
            padding:35px;
            border-radius:16px;
            color:#003e60;
        }

        h1 {
            text-align:center;
            color:#eaffff;
        }

        .localizador-box {
            background:#fff7e6;
            border-left:4px solid #f39c12;
            padding:12px 18px;
            border-radius:6px;
            margin:20px 0;
            font-size:18px;
        }

        ul {
            background:rgba(255,255,255,0.35);
            padding:15px;
            border-radius:8px;
            list-style:none;
        }

        ul li { margin-bottom:8px; }

        /* Botón estilo panel (el mismo que calendario y creación) */
        .btn-panel {
            display:inline-block;
            background:#006699;
            padding:10px 16px;
            border-radius:10px;
            color:white;
            text-decoration:none;
            font-weight:bold;
        }

        .btn-panel:hover {
            background:#004a80;
        }
    </style>
</head>

<body>

<div class="card">

    <h1>Reserva creada correctamente</h1>

    <!-- LOCALIZADOR -->
    <div class="localizador-box">
        <strong>Localizador:</strong> {{ $localizador }}
    </div>

    <h2 style="text-align:center; color:#003e60;">Detalles de la reserva</h2>

    <ul>
        <li><strong>Tipo:</strong> {{ $tipo_reserva_texto }}</li>
        <li><strong>Hotel:</strong> {{ $hotel_nombre }}</li>
        <li><strong>Viajeros:</strong> {{ $numero_viajeros }}</li>
    </ul>

    <div class="email-box" style="margin-top:15px;">
        Se ha enviado un correo con los detalles a:<br>
        <strong>{{ $email }}</strong>
    </div>

    <!-- BOTÓN VOLVER AL PANEL (ESTILO CORRECTO) -->
    <p style="margin-top:30px; text-align:center;">
        <a href="{{ route('admin.dashboard') }}" class="btn-panel">Volver al panel</a>
    </p>

</div>

</body>
</html>