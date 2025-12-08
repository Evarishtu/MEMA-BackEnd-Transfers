<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Gestión de Vehículos</title>
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
      max-width: 1200px;
      margin: 50px auto;
      background: rgba(0,0,0,0.25);
      border-radius: 20px;
      padding: 40px;
    }

    h2 {
      margin-top: 0;
      font-size: 30px;
    }

    .btn {
      display: inline-block;
      padding: 10px 18px;
      background: #3274ff;
      color: white;
      border-radius: 8px;
      text-decoration: none;
      font-weight: bold;
    }

    .btn:hover {
      background: #195dff;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      background: rgba(255,255,255,0.1);
      border-radius: 10px;
      overflow: hidden;
    }

    th {
      background: rgba(255,255,255,0.2);
      padding: 12px;
      text-align: left;
      font-size: 15px;
    }

    td {
      padding: 12px;
      border-bottom: 1px solid rgba(255,255,255,0.15);
    }

    tr:last-child td {
      border-bottom: none;
    }

    .acciones a {
      margin-right: 12px;
      color: #aee3ff;
      text-decoration: none;
      font-weight: bold;
    }

    .acciones a:hover {
      text-decoration: underline;
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

    <h2>🚗 Gestión de Vehículos</h2>

    <a href="{{route('vehiculo.create')}}" class="btn">➕ Nuevo vehículo</a>

    @if($vehiculos->isEmpty())
      <p style="margin-top:20px;">No hay vehículos registrados todavía.</p>
    @else
      <table>
        <thead>
          <tr>
            <th>ID Vehículo</th>
            <th>Descripción</th>
            <th>Acciones</th>
          </tr>
        </thead>

        <tbody>
          @foreach ($vehiculos as $vehiculo)
            <tr>
              <td>{{$vehiculo->id_vehiculo}}</td>
              <td>{{$vehiculo->descripcion}}</td>
              <td class="acciones">
                <a href="{{route('vehiculo.edit', $vehiculo->id_vehiculo)}}">✏️ Editar</a>
                <form action = "{{route('vehiculo.destroy', $vehiculo->id_vehiculo)}}" method = "POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                   <button type="submit" onclick="return confirm('¿Seguro que quieres eliminar este vehículo?');">🗑️ Eliminar</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @endif
  </div>

</body>
</html>