<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>{{ isset($vehiculo) ? 'Editar vehículo' : 'Crear nuevo vehículo' }}</title>

  <style>
    /* TODO EL CSS IGUAL QUE EL FORMULARIO ORIGINAL */
    body {
      margin: 0;
      font-family: "Arial", sans-serif;
      background: linear-gradient(135deg, #3a7bd5, #00d2ff);
      color: white;
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
    .container {
      max-width: 600px;
      margin: 50px auto;
      background: rgba(0,0,0,0.25);
      padding: 40px;
      border-radius: 20px;
    }
    input {
      width: 100%;
      padding: 12px;
      border-radius: 10px;
      border: none;
      margin-bottom: 20px;
    }
    .btn {
      background: #3274ff;
      padding: 10px 18px;
      color: white;
      border-radius: 10px;
      text-decoration: none;
      font-weight: bold;
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

    <h2>{{ isset($vehiculo) ? '✏️ Editar vehículo' : '🚗 Crear vehículo' }}</h2>

    <form action="{{ isset($vehiculo) ? route('vehiculo.update', $vehiculo->id_vehiculo)
                                       : route('vehiculo.store') }}"
          method="POST">

      @csrf
      @if(isset($vehiculo))
        @method('PUT')
      @endif

      <label>Descripción</label>
      <input type="text" name="descripcion"
             value="{{ $vehiculo->descripcion ?? '' }}" required>

      @if(!isset($vehiculo))
        <label>Email del conductor</label>
        <input type="email" name="email_conductor">

        <label>Contraseña del conductor</label>
        <input type="password" name="password_conductor">
      @endif

      <button class="btn" type="submit">
        {{ isset($vehiculo) ? 'Actualizar' : 'Guardar' }}
      </button>

    </form>

  </div>
</body>
</html>