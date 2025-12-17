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
        .form-grid{
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px 16px;
        }
        .form-group{
            display: flex;
            flex-direction: column;
        }
        .full{
            grid-column: 1 / 0;
        }
        input[type="date"],
        input[type="time"],
        input[type="text"],
        input[type="email"],
        input[type="number"],
        select {
            height: 44px;
            box-sizing: border-box;
        } 
        .card {
            width: 90%; max-width: 700px; margin: auto;
            background: rgba(255,255,255,0.32);
            backdrop-filter: blur(10px);
            padding: 30px; border-radius: 16px; color: #003e60;
        }

        h1, h2 { text-align: center; color: #eaffff; }
        h2 { color:#003e60; margin-top: -10px; }

        a { 
            font-weight:bold; 
            color:#003354; 
            text-decoration:none; 
        }

        fieldset {
            border: none; background: rgba(255,255,255,0.35);
            padding: 18px; border-radius: 12px; margin-bottom: 22px;
        }

        label { display:block; margin-top:10px; font-weight:bold; }
        input, select {
            width:100%; padding:10px; border:none;
            border-radius:8px; margin-top:6px;
        }
        legend{
            position: relative;
            top: 20px; 
            font-weight: bold;
            font-size: 20px;
            text-align: center;
            padding: 0px 12px; 
            margin: 0 auto 12px; 
            
        }
        button {
            width:100%; padding:12px; background:#007bff;
            border:none; border-radius:8px; color:white;
            font-weight:bold; font-size:16px;
            cursor:pointer; margin-top:10px;
        }
        .btn-volver {
            display: inline-block;
            margin-top: 10px;
            background:#006699;
            padding:10px 16px;
            border-radius:10px;
            color:white;
            text-decoration:none;
            font-weight:bold;
            align-items: center;
        }
        .btn-volver:hover {
            background:#004f73;
        }
        .container-boton{
            display: flex;
            justify-content: center;
            margin-top: 20px
        }
    </style>
</head>

<body>

<div class="card">

    <h1>Datos de la reserva</h1>
    <h2>Tipo seleccionado: <strong>{{ $tipo_nombre }}</strong></h2>

    <form method="POST" action="{{ route('hotel.reservas.guardar') }}">
        @csrf

        <input type="hidden" name="tipo_reserva" value="{{ $tipo }}">

        {{-- TIPO 1 --}}
        <fieldset id="vuelo_llegada" style="display:none;">
            <legend>Vuelo de llegada</legend>
            <div class="form-grid">
                <div class="form-group">
                    <label>Fecha llegada:</label>
                    <input type="date" name="fecha_entrada" value="{{ old('fecha_entrada') }}">
                    @error('fecha_entrada') <div class="error">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label>Hora llegada:</label>
                    <input type="time" name="hora_entrada" value="{{ old('hora_entrada') }}">
                    @error('hora_entrada') <div class="error">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label>Número vuelo:</label>
                    <input type="text" name="numero_vuelo_entrada" value="{{ old('numero_vuelo_entrada') }}">
                </div>
                <div class="form-group">
                    <label>Aeropuerto origen:</label>
                    <input type="text" name="origen_vuelo_entrada" value="{{ old('origen_vuelo_entrada') }}">
                </div>
            </div>
        </fieldset>

         {{-- TIPO 2 --}}
        <fieldset id="vuelo_salida" style="display:none;">
            <legend>Vuelo de salida</legend>
            <div class="form-grid">
                <div class="form-group">
                    <label>Fecha vuelo salida:</label>
                    <input type="date" name="fecha_vuelo_salida" value="{{ old('fecha_vuelo_salida') }}">
                    @error('fecha_vuelo_salida') <div class="error">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label>Hora vuelo salida:</label>
                    <input type="time" name="hora_vuelo_salida" value="{{ old('hora_vuelo_salida') }}">
                    @error('hora_vuelo_salida') <div class="error">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label>Número vuelo salida:</label>
                    <input type="text" name="numero_vuelo_salida" value="{{ old('numero_vuelo_salida') }}">
                </div>
                <div class="form-group">
                    <label>Hora recogida hotel:</label>
                    <input type="time" name="hora_recogida" value="{{ old('hora_recogida') }}">
                    @error('hora_recogida') <div class="error">{{ $message }}</div> @enderror
                </div>
            </div>
        </fieldset>

        {{-- DATOS ADICIONALES --}}
        <fieldset>
            <legend>Datos adicionales</legend>
            <div class="form-grid">
                <div class="form-group">
                    <label>Hotel:</label>
                    <input type="text" value="{{ auth('hotel')->user()->nombre }} " readonly>
                </div>
                <div class="form-group">
                    <label>Número de viajeros:</label>
                    <input type="number" name="numero_viajeros" min="1" value="{{ old('numero_viajeros') }}" required>
                    @error('numero_viajeros') <div class="error">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label>Email del cliente:</label>
                    <input type="email" name="email_cliente" value="{{ old('email_cliente') }}" required>
                    @error('email_cliente') <div class="error">{{ $message }}</div> @enderror
                </div>
                <div class="form-group full">
                    <label>Vehículo:</label>
                    <select name="id_vehiculo" required>
                        <option value="">-- Selecciona un vehículo --</option>
                        @foreach($vehiculos as $vehiculo)
                            <option value="{{ $vehiculo->id_vehiculo }}">{{ $vehiculo->descripcion }}</option>
                        @endforeach
                    </select>
                    @error('id_vehiculo') <div class="error">{{ $message }}</div> @enderror
                </div>
            </div>
            <button type="submit">Guardar Reserva</button>
        </fieldset>
    </form>
    <div class="container-boton">
        <a href="{{ route('hotel.reservas.crear') }}" class="btn-volver">Volver</a>
    </div>
</div>
    <script>
        const tipo = "{{ $tipo }}";
        document.getElementById('vuelo_salida').style.display = (tipo === "1" || tipo === "3") ? "block" : "none";
        document.getElementById('vuelo_llegada').style.display = (tipo === "2" || tipo === "3") ? "block" : "none";
    </script>
</body>
</html>
