<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comisiones por Hotel</title>
    <style>
        body {
            font-family: Arial;
            background: #f4f7fb;
            padding: 40px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }
        th, td {
            padding: 14px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th {
            background: #004a80;
            color: white;
        }
        h2 {
            margin-bottom: 20px;
        }
        .total {
            font-weight: bold;
            color: #004a80;
        }
    </style>
</head>
<body>

<h2>💰 Comisiones por hotel — {{ $mes }}</h2>

<form method="GET">
    <input type="month" name="mes" value="{{ $mes }}">
    <button type="submit">Filtrar</button>
</form>

<table>
    <thead>
        <tr>
            <th>Hotel</th>
            <th>Reservas</th>
            <th>Comisión total (€)</th>
        </tr>
    </thead>
    <tbody>
        @foreach($comisiones as $fila)
            <tr>
                <td>{{ $fila->hotel }}</td>
                <td>{{ $fila->total_reservas }}</td>
                <td class="total">{{ number_format($fila->total_comision, 2) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
