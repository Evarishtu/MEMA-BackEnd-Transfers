<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Alta Hotel</title>
</head>
<style>
    body {
        margin: 0;
        font-family: "Arial", sans-serif;
        background: linear-gradient(135deg, #3a7bd5, #00d2ff);
        color: #fff;
    }

    .navbar {
        background: #ffffff;
        padding: 15px 40px;
        border-bottom-left-radius: 20px;
        border-bottom-right-radius: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .navbar .left a {
        color: #2c3e50;
        text-decoration: none;
        font-size: 16px;
        font-weight: bold;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .navbar .right a {
        padding: 8px 16px;
        background: #3274ff;
        color: #fff;
        border-radius: 8px;
        text-decoration: none;
        font-size: 14px;
        font-weight: bold;
        transition: 0.2s;
        margin-left: 8px;
    }

    .navbar .right a:hover {
      background: #195dff;
    }

    .container {
        max-width: 800px;
        margin: 50px auto;
        background: rgba(0,0,0,0.25);
        border-radius: 20px;
        padding: 40px;
    }

    h2 {
        margin-top: 0;
        font-size: 30px;
    }

    form {
        
    }

    label {
        font-weight: bold;
        font-size: 15px;
    }

    input, select {
        width: 100%;
        padding: 12px;
        border-radius: 10px;
        border: none;
        margin-top: 8px;
        margin-bottom: 20px;
        font-size: 15px;
    }

    .btn, button {
        display: inline-block;
        padding: 10px 18px;
        background: #3274ff;
        color: white;
        border: none;
        border-radius: 8px;
        text-decoration: none;
        cursor: pointer;
        font-weight: bold;
        transition: 0.2s;
        margin-right: 10px;
    }

    .btn:hover, button:hover {
      background: #195dff;
    }
    button {
        background: #007bff;
        border: none;
        padding: 10px 18px;
        border-radius: 8px;
        color: white;
        cursor: pointer;
        font-weight: bold;
        font-size: 15px;
        width: 100%;
    }
    .btn-volver {
        display: inline-block;
        margin-top: 25px;
        background:#006699;
        padding:10px 16px;
        border-radius:10px;
        color:white;
        text-decoration:none;
        font-weight:bold;
    }
  </style>

<body>
<div class="container">
    <h2>🏨 Alta de usuario corporativo (Hotel)</h2>

    <form method="POST" action="{{ route('admin.hotel.store') }}">
        @csrf

        <label>Nombre del hotel:</label>
        <input type="text" name="nombre" required>

        <label>Zona:</label>
        <select name="id_zona">
            <option value="">-- Selecciona zona --</option>
            @foreach($zonas as $zona)
                <option value="{{ $zona->id_zona }}">
                    {{ $zona->descripcion }}
                </option>
            @endforeach
        </select>

        <label>Comisión (%):</label>
        <input type="number" name="comision" min="0" max="100">

        <label>Usuario:</label>
        <input type="text" name="usuario" required>

        <label>Contraseña:</label>
        <input type="password" name="password" required>

        <button type="submit">Crear hotel</button>
    </form>

    <a href="{{ route('admin.dashboard') }}" class="btn-volver">← Volver al panel</a>
</div>

</body>
</html>