<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas</title>

    <style>
        body {
            margin: 0;
            padding: 60px 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #3a7bd5, #00d2ff);
            color: #fff;
            min-height: 100vh;
        }

        .card {
            width: 92%;
            max-width: 1200px;
            margin: auto;
            background: rgba(255, 255, 255, 0.32);
            backdrop-filter: blur(10px);
            padding: 35px;
            border-radius: 18px;
            color: #003e60;
            box-shadow: 0 4px 12px rgba(0,0,0,0.20);
        }

        h1 {
            text-align: center;
            color: #eaffff;
            margin-bottom: 25px;
            font-size: 32px;
        }

        fieldset {
            border: none;
            background: rgba(255,255,255,0.4);
            padding: 18px;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        legend {
            font-weight: bold;
            font-size: 18px;
        }

        label {
            display: inline-block;
            margin-right: 20px;
            font-weight: bold;
        }

        input[type="date"],
        input[type="text"],
        select {
            padding: 8px;
            border-radius: 8px;
            border: none;
            margin-left: 5px;
        }

        .filtros-acciones {
            margin-top: 15px;
        }

        button {
            background: #007bff;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            color: #fff;
            cursor: pointer;
            font-weight: bold;
            margin-right: 10px;
        }
        button:hover {
            background: #0056b3;
        }

        .btn-limpiar {
            background: #555;
            padding: 10px 20px;
            border-radius: 8px;
            color: #fff;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
        }
        .btn-limpiar:hover {
            background: #333;
        }

        .table-container {
            overflow-x: auto;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: rgba(255,255,255,0.55);
            border-radius: 12px;
            overflow: hidden;
        }

        th {
            background: rgba(0, 80, 120, 0.9);
            color: white;
            padding: 12px;
        }

        td {
            padding: 12px;
            background: rgba(255,255,255,0.85);
        }

        tr:nth-child(even) td {
            background: rgba(255,255,255,0.70);
        }

        tr:hover td {
            background: rgba(0, 150, 200, 0.20);
        }

        tr {
            border-bottom: 1px solid rgba(0,0,0,0.15);
        }

        .btn-accion {
            padding: 8px 14px;
            border-radius: 8px;
            font-weight: bold;
            color: #fff;
            text-decoration: none;
            margin-right: 6px;
            display: inline-block;
        }

        .btn-ver { background: #1e88e5; }
        .btn-ver:hover { background: #1565c0; }

        .btn-editar { background: #43a047; }
        .btn-editar:hover { background: #2e7d32; }

        .btn-cancelar {
            background: #e53935;
            border: none;
            padding: 8px 14px;
            border-radius: 8px;
            color: white;
            cursor: pointer;
            font-weight: bold;
        }
        .btn-cancelar:hover {
            background: #b71c1c;
        }

        /* --------------------------- */
        /* Botón VOLVER AL PANEL       */
        /* --------------------------- */
        .btn-volver {
            display: inline-block;
            margin-top: 30px;
            background: #003e60;
            padding: 12px 22px;
            color: #fff;
            border-radius: 10px;
            font-weight: bold;
            text-decoration: none;
        }

        .btn-volver:hover {
            background: #002b44;
        }

    </style>
</head>

<body>

<div class="card">

    <h1>Consultar y gestionar reservas</h1>

    <!-- FORMULARIO DE FILTROS -->
    <form method="GET" action="{{ route('admin.reservas.index') }}">
        <fieldset>
            <legend>Filtros</legend>

            <label>
                Desde:
                <input type="date" name="desde" value="{{ request('desde') }}">
            </label>

            <label>
                Hasta:
                <input type="date" name="hasta" value="{{ request('hasta') }}">
            </label>

            <label>
                Tipo:
                <select name="tipo">
                    <option value="">(Todos)</option>
                    @foreach($tipos as $t)
                        <option value="{{ $t->id_tipo_reserva }}" {{ request('tipo') == $t->id_tipo_reserva ? 'selected' : '' }}>
                            {{ $t->descripcion }}
                        </option>
                    @endforeach
                </select>
            </label>

            <label>
                Hotel:
                <select name="hotel">
                    <option value="">(Todos)</option>
                    @foreach($hoteles as $h)
                        <option value="{{ $h->id_hotel }}" {{ request('hotel') == $h->id_hotel ? 'selected' : '' }}>
                            {{ $h->nombre }}
                        </option>
                    @endforeach
                </select>
            </label>

            <label>
                Búsqueda:
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Localizador o email">
            </label>

            <div class="filtros-acciones">
                <button type="submit">Aplicar</button>
                <a class="btn-limpiar" href="{{ route('admin.reservas.index') }}">Limpiar</a>
            </div>

        </fieldset>
    </form>

    <!-- TABLA -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Localizador</th>
                    <th>Fecha reserva</th>
                    <th>Tipo</th>
                    <th>Hotel</th>
                    <th>Email cliente</th>
                    <th>Viajeros</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
            @forelse($reservas as $r)
                <tr>
                    <td>{{ $r->localizador }}</td>
                    <td>{{ $r->fecha_reserva }}</td>
                    <td>{{ $r->tipo->descripcion }}</td>
                    <td>{{ $r->hotel->nombre }}</td>
                    <td>{{ $r->email_cliente }}</td>
                    <td>{{ $r->num_viajeros }}</td>

                    <td class="acciones">
                        <a class="btn-accion btn-ver" href="{{ route('admin.reservas.ver', $r->id_reserva) }}">Ver</a>

                        <a class="btn-accion btn-editar" href="{{ route('admin.reservas.editar', $r->id_reserva) }}">Editar</a>

                        <form action="{{ route('admin.reservas.cancelar', $r->id_reserva) }}"
                              method="POST"
                              style="display:inline;"
                              onsubmit="return confirm('¿Cancelar esta reserva?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn-cancelar">Cancelar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7"><em>No hay resultados</em></td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <!-- Botón Volver al panel con estilo uniforme -->
    <a class="btn-volver" href="{{ route('admin.dashboard') }}">Volver al panel</a>

</div>

</body>
</html>
