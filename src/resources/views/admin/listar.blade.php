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

        button {
            background: #007bff;
            border: none;
            padding: 10px 18px;
            border-radius: 8px;
            color: #fff;
            cursor: pointer;
            font-weight: bold;
        }

        button:hover {
            background: #0056b3;
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

        .acciones a, .acciones form {
            display: inline-block;
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
                        <option value="{{ $t->id_tipo_reserva }}"
                            {{ request('tipo') == $t->id_tipo_reserva ? 'selected' : '' }}>
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
                        <option value="{{ $h->id_hotel }}"
                            {{ request('hotel') == $h->id_hotel ? 'selected' : '' }}>
                            {{ $h->nombre }}
                        </option>
                    @endforeach
                </select>
            </label>

            <label>
                Búsqueda:
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Localizador o email">
            </label>

            <button type="submit">Aplicar</button>
            <a href="{{ route('admin.reservas.index') }}">Limpiar</a>
        </fieldset>
    </form>

    <!-- TABLA DE RESULTADOS -->
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
                            <a href="{{ route('admin.reservas.ver', $r->id_reserva) }}">Ver</a>
                            <a href="{{ route('admin.reservas.editar', $r->id_reserva) }}">Editar</a>

                            <form action="{{ route('admin.reservas.cancelar', $r->id_reserva) }}"
                                  method="POST"
                                  onsubmit="return confirm('¿Cancelar esta reserva?');"
                                  style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button>Cancelar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7"><em>No hay resultados</em></td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <p style="margin-top:25px;">
        <a href="{{ route('admin.dashboard') }}">⬅️ Volver al panel</a>
    </p>

</div>

</body>
</html>