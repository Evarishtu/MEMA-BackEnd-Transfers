<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>{{ isset($reservatipo) ? 'Editar tipo de reserva' : 'Crear tipo de reserva' }}</title>
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
      padding: 40px;
      background: rgba(0, 0, 0, 0.25);
      border-radius: 20px;
    }
    h2 {
      margin-top: 0;
      font-size: 28px;
    }
    label {
      display: block;
      margin-bottom: 8px;
      font-size: 16px;
      font-weight: bold;
    }
    input[type="text"] {
      width: 100%;
      padding: 12px;
      border-radius: 8px;
      border: none;
      margin-bottom: 20px;
      font-size: 16px;
    }
    .btn {
      padding: 10px 18px;
      background: #3274ff;
      color: white;
      border-radius: 8px;
      text-decoration: none;
      font-weight: bold;
      transition: 0.2s;
      border: none;
      cursor: pointer;
    }
    .btn:hover {
      background: #195dff;
    }
    .back-link {
      margin-left: 15px;
      color: #aee3ff;
      text-decoration: none;
      font-weight: bold;
    }
    .back-link:hover {
      text-decoration: underline;
    }
    .error-box {
      background: rgba(255, 0, 0, 0.25);
      padding: 12px;
      border-radius: 10px;
      margin-bottom: 15px;
    }
  </style>

</head>
<body>

  <div class="navbar">
    <div class="left">
      <a href="{{route('home')}}"><span>🏠</span> Volver al inicio</a>
    </div>
  </div>

  <div class="container">
    <h2>
      {{ isset($reservatipo) ? '✏️ Editar tipo de reserva' : '➕ Crear nuevo tipo de reserva' }}
    </h2>

    @if ($errors->any())
      <div class="error-box">
        <ul>
          @foreach ($errors->all() as $e)
            <li>{{ $e }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST"
          action="{{ isset($reservatipo) ? route('reservatipo.update', $reservatipo->id_tipo_reserva) : route('reservatipo.store') }}">

      @csrf

      @if(isset($reservatipo))
        @method('PUT')
      @endif

      <label>Descripción del tipo de reserva:</label>
      <input type="text" name="descripcion"
             value="{{ $reservatipo->descripcion ?? old('descripcion') }}"
             required>

      <button type="submit" class="btn">Guardar</button>

      <a href="{{ route('reservatipo.index') }}" class="back-link">Volver</a>

    </form>

  </div>

</body>
</html>
