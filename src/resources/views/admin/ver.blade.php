<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de reserva</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 60px 0;
            background: linear-gradient(135deg, #3a7bd5, #00d2ff);
            min-height: 100vh;
            color: #fff;
        }

        .card {
            width: 90%;
            max-width: 750px;
            margin: auto;
            background: rgba(255,255,255,0.35);
            backdrop-filter: blur(10px);
            padding: 35px;
            border-radius: 16px;
            color: #003e60;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }

        h1 {
            text-align: center;
            color: #eaffff;
        }

        h3 {
            margin-top: 25px;
            color: #003e60;
        }

        ul {
            margin-top: 10px;
            padding-left: 20px;
        }

        ul li {
            margin-bottom: 6px;
            font-size: 15px;
        }

        strong, b {
            color: #002b40;
        }

        a {
            color: #004b73;
            text-decoration: none;
            font-weight: bold;
            margin-right: 15px;
        }

        a:hover {
            text-decoration: underline;
        }

        .acciones {
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>

<body>

<div class="card">

    <h1>Reserva {{ $reserva->localizador }}</h1>

    <ul>
        <li><b>Tipo:</b> {{ $reserva->tipo_reserva->descripcion ?? 'Sin tipo' }}</li>
        <li><b>Hotel:</b> {{ $reserva->hotel->nombre ?? 'Sin hotel' }}</li>
        <li><b>Cliente:</b> {{ $reserva->email_cliente }}</li>
        <li><b>Fecha creación:</b> {{ $reserva->fecha_reserva }}</li>
        <li><b>Vehículo:</b> {{ $reserva->vehiculo->descripcion ?? 'No asignado' }}</li>
        <li><b>Número viajeros:</b> {{ $reserva->num_viajeros }}</li>
    </ul>

    {{-- ======================================================
         BLOQUE 1 — AEROPUERTO → HOTEL (TIPO 2 Y TIPO 3)
        ====================================================== --}}
    @if($reserva->id_tipo_reserva == 2 || $reserva->id_tipo_reserva == 3)
        <h3>Aeropuerto → Hotel</h3>
        <ul>
            <li><b>Fecha vuelo llegada:</b> {{ $reserva->fecha_entrada ?? '-' }}</li>
            <li><b>Hora vuelo llegada:</b> {{ $reserva->hora_entrada ?? '-' }}</li>
            <li><b>Número vuelo llegada:</b> {{ $reserva->numero_vuelo_entrada ?? '-' }}</li>
            <li><b>Origen vuelo:</b> {{ $reserva->origen_vuelo_entrada ?? '-' }}</li>
        </ul>
    @endif

    {{-- ======================================================
         BLOQUE 2 — HOTEL → AEROPUERTO (TIPO 1 Y TIPO 3)
        ====================================================== --}}
    @if($reserva->id_tipo_reserva == 1 || $reserva->id_tipo_reserva == 3)
        <h3>Hotel → Aeropuerto</h3>
        <ul>
            <li><b>Fecha vuelo salida:</b> {{ $reserva->fecha_vuelo_salida ?? '-' }}</li>
            <li><b>Hora vuelo salida:</b> {{ $reserva->hora_vuelo_salida ?? '-' }}</li>
            <li><b>Número vuelo salida:</b> {{ $reserva->numero_vuelo_salida ?? '-' }}</li>
            <li><b>Hora recogida en hotel:</b> {{ $reserva->hora_recogida ?? '-' }}</li>
        </ul>
    @endif

    <div class="acciones">
        <a href="{{ route('admin.reservas.editar', $reserva->id_reserva) }}">✏️ Editar</a>
        <a href="{{ route('admin.dashboard') }}">⬅️ Volver al panel</a>
    </div>

</div>

</body>
</html>