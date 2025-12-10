<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear reserva - Paso 2</title>

    <style>
        body {
            margin: 0; padding: 60px 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg,#3a7bd5,#00d2ff);
            color: #fff; min-height: 100vh;
        }

        .card {
            width: 90%; max-width: 700px; margin: auto;
            background: rgba(255,255,255,0.32);
            backdrop-filter: blur(10px);
            padding: 30px; border-radius: 16px; color: #003e60;
        }

        h1, h2 { text-align: center; color: #eaffff; }
        h2 { color:#003e60; margin-top: -10px; }

        fieldset {
            border: none; background: rgba(255,255,255,0.35);
            padding: 18px; border-radius: 12px; margin-bottom: 22px;
        }

        label { display:block; margin-top:10px; font-weight:bold; }
        input, select {
            width:100%; padding:10px; border:none;
            border-radius:8px; margin-top:6px;
        }

        button {
            width:100%; padding:12px; background:#007bff;
            border:none; border-radius:8px; color:white;
            font-weight:bold; font-size:16px;
            cursor:pointer; margin-top:10px;
        }

        a { font-weight:bold; color:#003354; text-decoration:none; }
    </style>
</head>

<body>

<div class="card">

    <h1>Datos de la reserva</h1>
    <h2>Tipo seleccionado: <strong>{{ $tipo_nombre }}</strong></h2>

    <form method="POST" action="{{ route('admin.reservas.guardar') }}">
        @csrf

        <input type="hidden" name="tipo_reserva" value="{{ $tipo }}">

        {{-- TIPO 1 --}}
        <fieldset id="vuelo_salida" style="display:none;">
            <legend>Vuelo de salida</legend>

            <label>Fecha vuelo salida:</label>
            <input type="date" name="fecha_vuelo_salida">

            <label>Hora vuelo salida:</label>
            <input type="time" name="hora_vuelo_salida">

            <label>Número vuelo salida:</label>
            <input type="text" name="numero_vuelo_salida">

            <label>Hora recogida hotel:</label>
            <input type="time" name="hora_recogida">
        </fieldset>

        {{-- TIPO 2 --}}
        <fieldset id="vuelo_llegada" style="display:none;">
            <legend>Vuelo de llegada</legend>

            <label>Fecha llegada:</label>
            <input type="date" name="fecha_entrada">

            <label>Hora llegada:</label>
            <input type="time" name="hora_entrada">

            <label>Número vuelo:</label>
            <input type="text" name="numero_vuelo_entrada">

            <label>Aeropuerto origen:</label>
            <input type="text" name="origen_vuelo_entrada">
        </fieldset>

        {{-- DATOS ADICIONALES --}}
        <fieldset>
            <legend>Datos adicionales</legend>

            <label>Hotel:</label>
            <select name="id_hotel" required>
                <option value="">-- Selecciona un hotel --</option>
                @foreach($hoteles as $h)
                    <option value="{{ $h->id_hotel }}">{{ $h->nombre }}</option>
                @endforeach
            </select>

            <label>Número de viajeros:</label>
            <input type="number" name="numero_viajeros" min="1" required>

            <label>Email del cliente:</label>
            <input type="email" name="email_cliente" required>

            <label>Vehículo:</label>
            <select name="id_vehiculo" required>
                <option value="">-- Selecciona un vehículo --</option>
                @foreach($vehiculos as $v)
                    <option value="{{ $v->id_vehiculo }}">{{ $v->descripcion }}</option>
                @endforeach
            </select>

            <button type="submit">Guardar Reserva</button>
        </fieldset>

    </form>

    <a href="{{ route('admin.reservas.crear') }}">Volver</a>
</div>

<script>
// ==========================================
// Mostrar/ocultar bloques según tipo
// ==========================================
const tipo = "{{ $tipo }}";
document.getElementById('vuelo_salida').style.display  = (tipo==="1"||tipo==="3") ? "block" : "none";
document.getElementById('vuelo_llegada').style.display = (tipo==="2"||tipo==="3") ? "block" : "none";



// ==========================================
// VALIDACIONES COMPLETAS DEL PHP ORIGINAL
// ==========================================
function validarHorasYFechas() {

    const fechaSalida  = document.querySelector('input[name="fecha_vuelo_salida"]');
    const horaSalida   = document.querySelector('input[name="hora_vuelo_salida"]');
    const fechaLlegada = document.querySelector('input[name="fecha_entrada"]');
    const horaLlegada  = document.querySelector('input[name="hora_entrada"]');
    const horaRecogida = document.querySelector('input[name="hora_recogida"]');

    // Reset
    horaRecogida?.setCustomValidity("");
    fechaSalida?.setCustomValidity("");
    horaSalida?.setCustomValidity("");

    switch (tipo) {

        case "1": // HOTEL → AEROPUERTO
            if (horaRecogida.value && horaSalida.value) {

                if (horaRecogida.value > horaSalida.value) {
                    horaRecogida.setCustomValidity("La hora de recogida no puede ser posterior a la del vuelo.");
                }

                if (horaRecogida.value === horaSalida.value) {
                    horaRecogida.setCustomValidity("La hora de recogida no puede ser igual a la del vuelo.");
                }
            }
            break;


        case "3": // IDA Y VUELTA

            // Recogida vs salida
            if (horaRecogida.value && horaSalida.value) {

                if (horaRecogida.value > horaSalida.value) {
                    horaRecogida.setCustomValidity("La hora de recogida no puede ser posterior al vuelo de ida.");
                }

                if (horaRecogida.value === horaSalida.value) {
                    horaRecogida.setCustomValidity("La hora de recogida no puede ser igual al vuelo de ida.");
                }
            }

            // Comparación fechas
            if (fechaSalida.value && fechaLlegada.value) {

                if (fechaSalida.value < fechaLlegada.value) {
                    fechaSalida.setCustomValidity("La fecha del vuelo de ida no puede ser posterior al de vuelta.");
                }
            }

            // Comparación horas si son el mismo día
            if (fechaSalida.value && fechaLlegada.value &&
                fechaSalida.value === fechaLlegada.value) {

                if (horaSalida.value > horaLlegada.value) {
                    horaSalida.setCustomValidity("La hora de ida no puede ser posterior a la de vuelta.");
                }

                if (horaSalida.value === horaLlegada.value) {
                    horaSalida.setCustomValidity("La hora de ida no puede ser igual a la de vuelta.");
                }
            }

            break;
    }
}


// Eventos
document.addEventListener("DOMContentLoaded", () => {

    document.querySelectorAll(
        'input[name="hora_vuelo_salida"], input[name="hora_recogida"], ' +
        'input[name="hora_entrada"], input[name="fecha_vuelo_salida"], input[name="fecha_entrada"]'
    ).forEach(el => el.addEventListener("change", validarHorasYFechas));

});
</script>

</body>
</html>
