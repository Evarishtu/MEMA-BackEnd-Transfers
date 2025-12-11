@extends('layouts.app')

@section('content')

<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: linear-gradient(135deg, #3a7bd5, #00d2ff);
        padding-top: 120px;
        padding-bottom: 60px;
        color: #fff;
        min-height: 100vh;
    }

    .card {
        width: 92%;
        max-width: 1100px;
        margin: auto;
        background: rgba(255, 255, 255, 0.3);
        backdrop-filter: blur(10px);
        border-radius: 18px;
        padding: 35px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        color: #fff;
    }

    h1 {
        text-align: center;
        margin-bottom: 30px;
        font-size: 32px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
        background: rgba(255, 255, 255, 0.5);
    }

    th, td {
        padding: 12px;
        text-align: center;
        color: #003b63;
        border-bottom: 1px solid rgba(0,0,0,0.2);
        font-weight: bold;
    }

    th {
        background-color: rgba(0, 80, 160, 0.8);
        color: #fff;
    }

    tr:nth-child(even) td {
        background-color: rgba(255, 255, 255, 0.35);
    }

    .no-reservas {
        text-align: center;
        font-size: 18px;
        margin-top: 10px;
        color: #fff;
    }

    a.back {
        display: block;
        text-align: center;
        margin-top: 35px;
        text-decoration: none;
        color: #e5f3ff;
        font-size: 18px;
        font-weight: bold;
    }

    a.back:hover {
        text-decoration: underline;
    }
</style>

<div class="card">

    <h1>Reservas de {{ $viajero->nombre }}</h1>

    @if ($reservas->count())
        <table>
            <thead>
                <tr>
                    <th>Localizador</th>
                    <th>Fecha Reserva</th>
                    <th>Tipo</th>
                    <th>Hotel / Destino</th>
                    <th>Zona</th>
                    <th>Nº Viajeros</th>
                    <th>Vehículo</th>
                    <th>Creado por</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reservas as $r)
                    <tr>
                        <td>{{ $r->localizador }}</td>
                        <td>{{ $r->fecha_reserva }}</td>
                        <td>{{ $r->tipo->descripcion ?? '-' }}</td>
                        <td>{{ $r->hotel->nombre ?? '-' }}</td>
                        <td>{{ $r->zona->descripcion ?? '-' }}</td>
                        <td>{{ $r->num_viajeros }}</td>
                        <td>{{ $r->vehiculo->descripcion ?? '-' }}</td>
                        <td>{{ $r->usuario_creacion }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="no-reservas">Aún no tienes reservas registradas.</p>
    @endif

    <a class="back" href="{{ route('viajero.dashboard') }}">← Volver al panel</a>

</div>

@endsection