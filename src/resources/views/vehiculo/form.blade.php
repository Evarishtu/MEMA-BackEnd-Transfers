<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>{{isset($vehiculo) ? 'Editar Vehículo' : 'Crear Vehículo'}}</title>
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
      max-width: 600px;
      margin: 50px auto;
      background: rgba(0,0,0,0.25);
      border-radius: 20px;
      padding: 40px;
    }

    h2 {
      margin-top: 0;
      font-size: 28px;
    }

    label {
      font-weight: bold;
      margin-top: 15px;
      display: block;
    }

    input {
      width: 100%;
      padding: 12px;
      border-radius: 10px;
      border: none;
      margin-top: 8px;
      margin-bottom: 20px;
      font-size: 15px;
    }

    .btn, button {
      padding: 10px 18px;
      background: #3274ff;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      text-decoration: none;
      font-weight: bold;
      margin-right: 10px;
      transition: 0.2s;
    }

    .btn:hover, button:hover {
      background: #195dff;
    }
  </style>

</head>
<body>

  <div class="navbar">
    <div class="left">
      <a href="{{route('home')}}"><span>🏠</span> Volver al inicio</a>
    </div>
    <div class="right">
      <a href="{{route('login')}}">Iniciar sesión</a>
      <a href="{{route('registro.index')}}">Registrarse</a>
    </div>
  </div>

  <div class="container">

    <h2>{{isset($vehiculo) ? '✏️ Editar vehículo' : '🚗 Crear nuevo vehículo' }}</h2>

    <form method="POST" action="{{isset($vehiculo) ? route('vehiculo.update', $vehiculo->id_vehiculo) : route('vehiculo.store')}}">
      @csrf
      @if(isset($vehiculo))
        @method('PUT')
      @endif

      <label for="descripcion">Descripción del vehículo:</label>
      <input type="text" id="descripcion" name="descripcion"
             value="{{old('descripcion', $vehiculo->descripcion ?? '')}}" required>

      @if(!isset($vehiculo))
        <label for="email_conductor">Email del conductor:</label>
        <input type="email" id="email_conductor" name="email_conductor">

        <label for="password_conductor">Contraseña del conductor:</label>
        <input type="password" id="password_conductor" name="password_conductor">
      @endif

      <button type="submit">
        {{isset($vehiculo) ? 'Actualizar Vehículo' : 'Guardar Vehículo'}}
      </button>

      <a href="{{route('vehiculo.index')}}" class="btn">⬅️ Volver al listado</a>

    </form>

  </div>

</body>
</html>