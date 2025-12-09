<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>{{ isset($hotel) ? 'Editar hotel' : 'Crear nuevo hotel' }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
  </style>

</head>
<body>

  <div class="navbar">
    <div class="left">
      <a href="{{ route('hotel.index') }}"><span>🏠</span> Volver al listado</a>
    </div>
  </div>

  <div class="container">

    <h2>{{ isset($hotel) ? '✏️ Editar hotel' : '🏨 Crear nuevo hotel' }}</h2>

    <!-- ERRORES -->
    @if ($errors->any())
      <div style="background:rgba(255,0,0,0.25);padding:12px;border-radius:10px;margin-bottom:20px;">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST"
          action="{{ isset($hotel) ? route('hotel.update', $hotel->id_hotel) : route('hotel.store') }}">
      @csrf

      @if(isset($hotel))
        @method('PUT')
      @endif

      <label for="nombre">Nombre del hotel:</label>
      <input type="text" name="nombre" value="{{ $hotel->nombre ?? old('nombre') }}" required>

      <label for="id_zona">Zona:</label>
      <select name="id_zona" required>
        <option value="">-- Selecciona una zona --</option>
        @foreach ($zonas as $zona)
          <option value="{{ $zona->id_zona }}"
            @if(isset($hotel) && $hotel->id_zona == $zona->id_zona) selected @endif>
            {{ $zona->descripcion }}
          </option>
        @endforeach
      </select>

      <label for="comision">Comisión (%):</label>
      <input type="number" name="comision" value="{{ $hotel->comision ?? old('comision') }}">

      <label for="usuario">Usuario:</label>
      <input type="text" name="usuario" value="{{ $hotel->usuario ?? old('usuario') }}">

      <label for="password">Contraseña:</label>
      <input type="password" name="password">

      <button type="submit">Guardar hotel</button>
      <a href="{{ route('hotel.index') }}" class="btn">⬅️ Volver</a>

    </form>

  </div>

</body>
</html>