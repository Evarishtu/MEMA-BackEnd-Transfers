<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comisiones mensuales</title>
    <style>
        body{
            font-family: Arial, sens-serif;
            background: linear-gradient(135deg, #3a7bd5, #00d2ff);
            color: #fff;
            padding: 80px;
        }
        .card{
            max-width: 700px;
            margin: auto;
            background: rgba(255,255,255,0.25);
            padding: 30px;
            border-radius: 18px;
        }
        table{
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td{
            padding: 10px;
            background: rgba(255,255,255,0.35);
            color: #003b63;
            text-align: center;
        }
        th{
            background: rgba(255,255,255,0.6);
        }
        .btn-panel {
            display:inline-block;
            background:#006699;
            padding:10px 16px;
            border-radius:10px;
            color:white;
            text-decoration:none;
            font-weight:bold;
        }
        .btn-panel:hover {
            background:#004a80;
        }
    </style>
</head>
<body>
    <div class="card">
        <h2>Comisiones mensuales</h2>
        <p>Hotel: <strong>{{$hotel->nombre}}</strong></p>

        @if($comisiones->count())
        <table>
            <thead>
                <tr>
                    <th>Mes / Año</th>
                    <th>Reservas</th>
                    <th>Comisión por reserva</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($comisiones as $comision)
                    @php
                        $total = $comision->total_reservas * $hotel->comision;
                    @endphp
                    <tr>
                        <th>{{sprintf('%02d', $comision->month)}}/{{$comision->year}}</th>
                        <th>{{$comision->total_reservas}}</th>
                        <th>{{$hotel->comision}} €</th>
                        <th>{{$total}} €</th>
                    </tr>
                @endforeach 
            </tbody>
        </table>
        @else
        <p>No hay comisiones registradas.</p>
        @endif
        <p style="margin-top:30px; text-align:center;">
            <a href="{{route('hotel.dashboard')}}" class="btn-panel">Volver al panel</a>
        </p>
    </div>
</body>
</html>