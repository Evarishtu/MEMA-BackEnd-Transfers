<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas</title>
    <style>
        body{
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #3a7bd5, #00d2ff);
            padding-top: 120px;
            padding-bottom: 60px;
            color: #fff;
            min-height: 100vh;
        }
        .card{
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
        table{
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            background: rgba(255, 255, 255, 0.5);
        }
        th, td{
            padding: 12px;
            text-align: center;
            color: #003b63;
            border-bottom: 1px solid rgba(0,0,0,0.2);
            font-weight: bold;
        }
        th{
            background-color: rgba(0, 80, 160, 0.8);
            color: #fff;
        }
        tr:nth-child(even) td {
            background-color: rgba(255, 255, 255, 0.35);
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
        p,
        .volver{
            margin-top:30px;
            text-align:center;
        }
    </style>
</head>
<body>
    <div class= "card">
        <h1>Reservas de {{$hotel->nombre}}</h1>
        
        <table>
            <thead>
                <tr>
                    <th>Localizador</th>
                    <th>Fecha</th>
                    <th>Tipo</th>
                    <th>Email cliente</th>
                    <th>Creada por</th>
                    <th>Comisión</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservas as $reserva)
                <tr>
                    <td>{{$reserva->localizador}}</td>
                    <td>{{\Carbon\Carbon::parse($reserva->fecha_reserva)->format('d/m/Y')}}</td>
                    <td>{{$reserva->tipo->descripcion ?? '-'}}</td>
                    <td>{{$reserva->email_cliente}}</td>
                    <td>{{$reserva->usuario_creacion}}</td>
                    <td>
                        @if($reserva->usuario_creacion === 'corporativo')
                            {{ $reserva->hotel->comision ?? 10 }} €
                        @else
                            0 €
                        @endif
                    </td>
                </tr>
                @endforeach 
            </tbody>
        </table>
        <p class="volver">
            <a href="{{route('hotel.dashboard')}}" class="btn-panel">Volver al panel</a>
        </p>
    </div>
</body>
</html>