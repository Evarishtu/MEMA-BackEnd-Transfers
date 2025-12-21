<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calendario de trayectos</title>

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
            max-width: 1100px;
            margin: auto;
            background: rgba(255, 255, 255, 0.32);
            backdrop-filter: blur(10px);
            padding: 35px;
            border-radius: 18px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.20);
            color: #003e60;
        }

        h1 {
            text-align: center;
            margin-top: 0;
            margin-bottom: 25px;
            color: #eaffff;
            font-size: 32px;
        }

        h2 {
            color: #004b6e;
            margin-top: 35px;
        }

        form {
            margin-bottom: 25px;
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        label {
            font-weight: bold;
        }

        select, input[type="date"] {
            padding: 8px;
            border-radius: 8px;
            border: none;
            font-size: 15px;
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
            transition: 0.2s;
        }

        button:hover {
            background: #0056b3;
        }

        a {
            color: #003354;
            font-weight: bold;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: rgba(255,255,255,0.55);
            border-radius: 12px;
            overflow: hidden;
            margin-top: 20px;
        }

        th {
            background: rgba(0, 80, 120, 0.9);
            color: white;
            padding: 12px;
        }

        td {
            padding: 12px;
            background: rgba(255,255,255,0.85);
            vertical-align: top;
        }

        tr:nth-child(even) td {
            background: rgba(255,255,255,0.70);
        }

        .mes-out {
            background: rgba(230, 230, 230, 0.55) !important;
        }

        .evento {
            margin-bottom: 8px;
        }

        em {
            color: #666;
        }

    </style>
</head>

<body>
    <div class="card">

        <h1>Calendario de trayectos</h1>

        <!-- FORMULARIO DE FILTROS -->
        <form method="GET" action="{{ route('admin.calendario') }}">
            <label>
                Vista:
                <select name="vista">
                    <option value="dia"   {{ $vista === 'dia' ? 'selected' : '' }}>Día</option>
                    <option value="semana"{{ $vista === 'semana' ? 'selected' : '' }}>Semana</option>
                    <option value="mes"   {{ $vista === 'mes' ? 'selected' : '' }}>Mes</option>
                </select>
            </label>

            <label>
                Fecha base:
                <input type="date" name="fecha" value="{{ $fecha_base }}">
            </label>

            <button type="submit">Ir</button>
        </form>


        {{-- ======================== VISTA DÍA ======================== --}}
        @if ($vista === 'dia')

            <h2>Día: {{ $fecha_base }}</h2>

            <table>
                <thead>
                    <tr>
                        <th>Hora</th>
                        <th>Reserva</th>
                    </tr>
                </thead>
                <tbody>
                @php
                    $eventosDia = $eventos->filter(fn($e) =>
                        $e->fecha_entrada === $fecha_base ||
                        $e->fecha_vuelo_salida === $fecha_base
                    )->sortBy(function($e){
                        return $e->hora_entrada ?? $e->hora_vuelo_salida ?? '00:00';
                    });
                @endphp

                @if ($eventosDia->isEmpty())
                    <tr><td colspan="2"><em>Sin eventos</em></td></tr>
                @else
                    @foreach ($eventosDia as $e)
                        <tr>
                            <td>{{ $e->hora_entrada ?? $e->hora_vuelo_salida }}</td>
                            <td>
                                <a href="{{ route('admin.reservas.ver', $e->id_reserva) }}">
                                    {{ $e->localizador }}
                                </a>
                                — {{ $e->tipo_reserva->descripcion }}
                                — {{ $e->hotel->nombre }}
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>


        {{-- ======================== VISTA SEMANA ======================== --}}
        @elseif ($vista === 'semana')

            <h2>Semana de {{ $fecha_base }}</h2>

            <table>
                <thead>
                    <tr>
                        @foreach ($diasSemana as $d)
                            <th>{{ $d }}</th>
                        @endforeach
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        @foreach ($diasSemana as $d)

                            @php
                                $ev = $eventos->filter(fn($e) =>
                                    $e->fecha_entrada === $d ||
                                    $e->fecha_vuelo_salida === $d
                                );
                            @endphp

                            <td>
                                @if ($ev->isEmpty())
                                    <em>Sin eventos</em>
                                @else
                                    @foreach ($ev as $e)
                                        <div class="evento">
                                            <a href="{{ route('admin.reservas.ver', $e->id_reserva) }}">
                                                {{ $e->localizador }}
                                            </a>
                                            <br>
                                            <small>{{ $e->tipo_reserva->descripcion }} · {{ $e->hora_entrada ?? $e->hora_vuelo_salida }}</small>
                                            <br>
                                            <small>{{ $e->hotel->nombre }}</small>
                                        </div>
                                    @endforeach
                                @endif
                            </td>

                        @endforeach
                    </tr>
                </tbody>
            </table>


        {{-- ======================== VISTA MES ======================== --}}
        @else

            <h2>Mes de {{ substr($fecha_base,0,7) }}</h2>

            <table>
                <thead>
                    <tr>
                        <th>Lun</th>
                        <th>Mar</th>
                        <th>Mié</th>
                        <th>Jue</th>
                        <th>Vie</th>
                        <th>Sáb</th>
                        <th>Dom</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($calendar as $week)
                        <tr>
                            @foreach ($week as $day)
                                @php
                                    $isMonth = substr($day,0,7) === substr($fecha_base,0,7);

                                    $ev = $eventos->filter(fn($e) =>
                                        $e->fecha_entrada === $day ||
                                        $e->fecha_vuelo_salida === $day
                                    );
                                @endphp

                                <td class="{{ $isMonth ? '' : 'mes-out' }}">
                                    <strong>{{ substr($day,8,2) }}</strong><br>

                                    @if ($ev->isEmpty())
                                        <small><em>—</em></small>
                                    @else
                                        @foreach ($ev as $e)
                                            <div class="evento">
                                                <a href="{{ route('admin.reservas.ver', $e->id_reserva) }}">
                                                    {{ $e->localizador }}
                                                </a>
                                                <br>
                                                <small>{{ $e->tipo_reserva->descripcion }} · {{ $e->hora_entrada ?? $e->hora_vuelo_salida }}</small>
                                            </div>
                                        @endforeach
                                    @endif

                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>

        @endif


        {{-- ================= BOTONES DE NAVEGACIÓN ================= --}}
        <div style="margin-top:35px; display:flex; gap:20px; justify-content:center;">

            <a href="{{ route('admin.dashboard') }}"
               style="background:#006699; padding:10px 16px; border-radius:10px; color:white; text-decoration:none; font-weight:bold;">
                Ir al panel
            </a>

            <a href="{{ route('admin.reservas.index') }}"
               style="background:#004a80; padding:10px 16px; border-radius:10px; color:white; text-decoration:none; font-weight:bold;">
                Ir al listado
            </a>

        </div>

    </div>
</body>
</html>