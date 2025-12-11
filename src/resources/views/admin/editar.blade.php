<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar reserva</title>

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
            width: 95%;
            max-width: 850px;
            margin: auto;
            background: rgba(255,255,255,0.35);
            backdrop-filter: blur(10px);
            padding: 35px;
            border-radius: 16px;
            color: #003e60;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }

        h1 {
            text-align: center;
            color: #eaffff;
            margin-top: 0;
            margin-bottom: 30px;
        }

        fieldset {
            border: none;
            margin-bottom: 30px;
            background: rgba(255,255,255,0.25);
            padding: 20px;
            border-radius: 12px;
        }

        legend {
            font-weight: bold;
            color: #003e60;
            margin-bottom: 10px;
            font-size: 18px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-top: 10px;
            color: #003e60;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 4px;
            border: none;
            border-radius: 8px;
            background: #fff;
            font-size: 14px;
        }

        button {
            background: #006bb3;
            color: white;
            padding: 12px 22px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            font-size: 15px;
        }

        button:hover {
            background: #005c99;
        }

        a {
            color: #003a5c;
            font-weight: bold;
            text-decoration: none;
            margin-left: 15px;
        }

        a:hover {
            text-decoration: underline;
        }

        .actions {
            text-align: center;
            margin-top: 25px;
        }
    </style>
</head>

<body>

<div class="card">

    <h1>Editar reserva {{ $reserva->localizador }}</h1>

    <form method="POST" action="{{ route('admin.reservas.actualizar', $reserva->id_reserva) }}">
        @csrf
        @method('PUT')

        <!-- DATOS GENERALES -->
        <fieldset>
            <legend>Datos generales</legend>

            <label>Tipo de reserva:</label>
            <select name="id_tipo_reserva" id="tipo_reserva" required onchange="mostrarCampos()">
                @foreach($tipos as $t)
                    <option value="{{ $t->id_tipo_reserva }}"
                        {{ $reserva->id_tipo_reserva == $t->id_tipo_reserva ? 'selected' : '' }}>
                        {{ $t->descripcion }}
                    </option>
                @endforeach
            </select>

            <label>Hotel:</label>
            <select name="id_hotel" required>
                @foreach($hoteles as $h)
                    <option value="{{ $h->id_hotel }}"
                        {{ $reserva->id_hotel == $h->id_hotel ? 'selected' : '' }}>
                        {{ $h->nombre }}
                    </option>
                @endforeach
            </select>

            <label>Email del cliente:</label>
            <input type="email" name="email_cliente"
                   value="{{ $reserva->email_cliente }}" required>

            <label>Número de viajeros:</label>
            <input type="number" name="num_viajeros"
                   value="{{ $reserva->num_viajeros }}" required>

            <label>Vehículo asignado:</label>
            <select name="id_vehiculo" required>
                @foreach($vehiculos as $v)
                    <option value="{{ $v->id_vehiculo }}"
                        {{ $reserva->id_vehiculo == $v->id_vehiculo ? 'selected' : '' }}>
                        {{ $v->descripcion }}
                    </option>
                @endforeach
            </select>
        </fieldset>

        <!-- AEROPUERTO → HOTEL -->
        <fieldset id="bloque_llegada">
            <legend>Aeropuerto → Hotel</legend>

            <label>Fecha llegada:</label>
            <input type="date" name="fecha_entrada" value="{{ $reserva->fecha_entrada }}">

            <label>Hora llegada:</label>
            <input type="time" name="hora_entrada" value="{{ $reserva->hora_entrada }}">

            <label>Número vuelo llegada:</label>
            <input type="text" name="numero_vuelo_entrada" value="{{ $reserva->numero_vuelo_entrada }}">

            <label>Origen vuelo:</label>
            <input type="text" name="origen_vuelo_entrada" value="{{ $reserva->origen_vuelo_entrada }}">
        </fieldset>

        <!-- HOTEL → AEROPUERTO -->
        <fieldset id="bloque_salida">
            <legend>Hotel → Aeropuerto</legend>

            <label>Fecha vuelo salida:</label>
            <input type="date" name="fecha_vuelo_salida" value="{{ $reserva->fecha_vuelo_salida }}">

            <label>Hora vuelo salida:</label>
            <input type="time" name="hora_vuelo_salida" value="{{ $reserva->hora_vuelo_salida }}">

            <label>Número vuelo salida:</label>
            <input type="text" name="numero_vuelo_salida" value="{{ $reserva->numero_vuelo_salida }}">

            <label>Hora recogida:</label>
            <input type="time" name="hora_recogida" value="{{ $reserva->hora_recogida }}">
        </fieldset>

        <div class="actions">
            <button type="submit">Guardar cambios</button>
            <a href="{{ route('admin.reservas.ver', $reserva->id_reserva) }}">Cancelar</a>
        </div>

    </form>

</div>

<script>
function mostrarCampos() {
    const tipo = document.getElementById('tipo_reserva').value;
    const llegada = document.getElementById('bloque_llegada');
    const salida  = document.getElementById('bloque_salida');

    if (tipo === "1") { llegada.style.display = "none"; salida.style.display = "block"; }
    else if (tipo === "2") { llegada.style.display = "block"; salida.style.display = "none"; }
    else { llegada.style.display = "block"; salida.style.display = "block"; }
}

document.addEventListener("DOMContentLoaded", mostrarCampos);
</script>

</body>
</html>