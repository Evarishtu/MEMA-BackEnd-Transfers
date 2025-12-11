<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Reserva</title>

    <style>
        body {
            margin: 0;
            font-family: "Arial", sans-serif;
            background: linear-gradient(135deg, #3a7bd5, #00d2ff);
            color: #fff;
            display: flex;
            justify-content: center;
            padding-top: 120px;
            padding-bottom: 80px;
            min-height: 100vh;
        }

        .card {
            width: 90%;
            max-width: 700px;
            background: rgba(255, 255, 255, 0.35);
            backdrop-filter: blur(10px);
            border-radius: 18px;
            padding: 35px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            color: #fff;
        }

        h1 {
            text-align: center;
            margin-top: 0;
            margin-bottom: 25px;
            font-size: 32px;
            font-weight: bold;
        }

        fieldset {
            border: none;
            background: rgba(255,255,255,0.15);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 25px;
        }

        legend {
            font-size: 18px;
            font-weight: bold;
            padding: 0 6px;
            margin-bottom: 10px;
        }

        label {
            display: block;
            margin-top: 12px;
            font-weight: bold;
        }

        input, select {
            margin-top: 6px;
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            border: none;
            outline: none;
            font-size: 15px;
        }

        button {
            width: 100%;
            padding: 14px;
            background: #1f8fff;
            border: none;
            color: #fff;
            font-size: 17px;
            border-radius: 12px;
            cursor: pointer;
            margin-top: 10px;
            transition: 0.3s;
            font-weight: bold;
        }

        a.volver {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            font-size: 16px;
            color: #e5f3ff;
            font-weight: bold;
        }

        a.volver:hover {
            text-decoration: underline;
        }
    </style>

</head>
<body>

<div class="card">
    <h1>📝 Crear Reserva</h1>

    <form method="POST" action="{{ route('viajero.reservas.store') }}">
        @csrf

        {{-- TIPO DE RESERVA --}}
        <fieldset>
            <legend>Tipo de reserva</legend>
            <select name="id_tipo_reserva" id="tipo_reserva" required onchange="mostrarCampos()">
                <option value="">-- Selecciona tipo de reserva --</option>

                @foreach($tiposReserva as $tipo)
                    <option value="{{ $tipo->id_tipo_reserva }}">
                        {{ $tipo->descripcion }}
                    </option>
                @endforeach
            </select>
        </fieldset>

        {{-- BLOQUE: VUELO SALIDA --}}
        <fieldset id="vuelo_salida" style="display:none;">
            <legend>Vuelo de salida (Hotel → Aeropuerto)</legend>

            <label>Fecha vuelo salida:</label>
            <input type="date" name="fecha_vuelo_salida">

            <label>Hora vuelo salida:</label>
            <input type="time" name="hora_vuelo_salida">

            <label>Número de vuelo salida:</label>
            <input type="text" name="numero_vuelo_salida">

            <label>Hora recogida en hotel:</label>
            <input type="time" name="hora_recogida">
        </fieldset>

        {{-- BLOQUE: VUELO LLEGADA --}}
        <fieldset id="vuelo_llegada" style="display:none;">
            <legend>Vuelo de llegada (Aeropuerto → Hotel)</legend>

            <label>Fecha llegada:</label>
            <input type="date" name="fecha_entrada">

            <label>Hora llegada:</label>
            <input type="time" name="hora_entrada">

            <label>Número de vuelo:</label>
            <input type="text" name="numero_vuelo_entrada">

            <label>Aeropuerto de origen:</label>
            <input type="text" name="origen_vuelo_entrada">
        </fieldset>

        {{-- DATOS ADICIONALES --}}
        <fieldset>
            <legend>Datos adicionales</legend>

            <label>Hotel:</label>
            <select name="id_hotel" required>
                <option value="">-- Selecciona un hotel --</option>

                @foreach($hoteles as $hotel)
                    <option value="{{ $hotel->id_hotel }}">
                        {{ $hotel->nombre }}
                    </option>
                @endforeach
            </select>

            <label>Número de viajeros:</label>
            <input type="number" name="num_viajeros" min="1" required>

            <label>Email del cliente:</label>
            <input type="email" value="{{ $viajero->email }}" readonly>

            <label>Vehículo:</label>
            <select name="id_vehiculo" required>
                <option value="">-- Selecciona un vehículo --</option>

                @foreach($vehiculos as $vehiculo)
                    <option value="{{ $vehiculo->id_vehiculo }}">
                        {{ $vehiculo->descripcion }}
                    </option>
                @endforeach

            </select>
        </fieldset>

        <button type="submit">Guardar reserva</button>
    </form>

    <a href="{{ route('viajero.dashboard') }}" class="volver">← Volver al dashboard</a>
</div>

<script>
function mostrarCampos() {
    const tipo = document.getElementById('tipo_reserva').value;

    document.getElementById('vuelo_salida').style.display =
        (tipo == "1" || tipo == "3") ? 'block' : 'none';

    document.getElementById('vuelo_llegada').style.display =
        (tipo == "2" || tipo == "3") ? 'block' : 'none';
}
</script>

</body>
</html>