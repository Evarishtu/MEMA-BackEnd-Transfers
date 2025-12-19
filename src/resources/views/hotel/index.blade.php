<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Gestión de Hoteles</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <style>
    /* TODO EL CSS ORIGINAL PEGADO AQUÍ (idéntico) */
    body { margin:0; font-family:Arial; background:linear-gradient(135deg,#3a7bd5,#00d2ff); color:#fff; }
    .navbar { background:#fff; padding:15px 40px; border-bottom-left-radius:20px; border-bottom-right-radius:20px; display:flex; justify-content:space-between; align-items:center; }
    .navbar .left a { color:#2c3e50; font-weight:bold; text-decoration:none; font-size:16px; display:flex; align-items:center; gap:6px; }
    .container { max-width:1200px; margin:50px auto; background:rgba(0,0,0,0.25); border-radius:20px; padding:40px; }
    table { width:100%; border-collapse:collapse; margin-top:20px; background:rgba(255,255,255,0.1); border-radius:10px; overflow:hidden; }
    th { background:rgba(255,255,255,0.2); padding:12px; text-align:left; }
    td { padding:12px; border-bottom:1px solid rgba(255,255,255,0.15); }
    .btn { padding:10px 18px; background:#3274ff; color:#fff; border-radius:8px; text-decoration:none; font-weight:bold; }
    .acciones a { color:#aee3ff; text-decoration:none; margin-right:12px; font-weight:bold; }
  </style>

</head>
<body>

  <div class="navbar">
    <div class="left">
      <a href="{{ url('/') }}"><span>🏠</span> Volver al inicio</a>
    </div>
  </div>

  <div class="container">

    <h2>🏨 Gestión de Hoteles</h2>

    <a href="{{ route('hotel.create') }}" class="btn">➕ Nuevo hotel</a>

    @if ($hoteles->isEmpty())
      <p style="margin-top:20px;">No hay hoteles registrados.</p>

    @else
      <table>
        <thead>
          <tr>
            <th>ID Hotel</th>
            <th>Nombre</th>
            <th>Zona</th>
            <th>Acciones</th>
          </tr>
        </thead>

        <tbody>
          @foreach ($hoteles as $hotel)
            <tr>
              <td>{{ $hotel->id_hotel }}</td>
              <td>{{ $hotel->nombre }}</td>
              <td>{{ $hotel->zona->descripcion ?? 'Sin zona asignada' }}</td>
              <td class="acciones">

                <a href="{{ route('hotel.edit', $hotel->id_hotel) }}">✏️ Editar</a>

                <form method="POST" action="{{ route('hotel.destroy', $hotel->id_hotel) }}" style="display:inline-block">
                  @csrf
                  @method('DELETE')
                  <button type="submit"
                    style="background:none;border:none;color:#aee3ff;cursor:pointer"
                    onclick="return confirm('¿Seguro que quieres eliminar este hotel?');">
                    🗑️ Eliminar
                  </button>
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