<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comisiones mensuales</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            margin: 0;
            padding: 40px;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #3a7bd5, #00d2ff);
            color: #003b63;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            background: rgba(255,255,255,0.95);
            border-radius: 18px;
            padding: 35px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }

        h1 {
            margin-top: 0;
            margin-bottom: 25px;
            font-size: 28px;
            color: #004a80;
        }

        .filtro {
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .filtro label {
            font-weight: bold;
        }

        .filtro input[type="month"] {
            padding: 8px 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        .filtro button {
            padding: 8px 16px;
            background: #3274ff;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
        }

        .filtro button:hover {
            background: #195dff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        thead th {
            background: #004a80;
            color: white;
            padding: 14px;
            text-align: center;
            font-size: 14px;
        }

        tbody td {
            padding: 14px;
            text-align: center;
            border-bottom: 1px solid #ddd;
            font-size: 14px;
        }

        tbody td:first-child {
            text-align: left;
            font-weight: bold;
        }

        tbody tr:hover {
            background: #f1f6ff;
        }

        .total {
            font-weight: bold;
            color: #004a80;
        }

        .volver {
            display: inline-block;
            margin-top: 25px;
            padding: 10px 18px;
            background: #006699;
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-weight: bold;
        }

        .volver:hover {
            background: #004f73;
        }

        @media (max-width: 900px) {
            body {
                padding: 15px;
            }

            .container {
                padding: 20px;
            }

            table {
                font-size: 12px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <h1>💰 Comisiones del hotel</h1>

    <p>
        Hotel: <strong>{{ $hotel->nombre }}</strong>
    </p>

    <!-- FILTRO DE MES -->
    <form method="GET" class="filtro">
        <label for="mes">Mes:</label>
        <input
            type="month"
            id="mes"
            name="mes"
            value="{{ $mes }}"
        >
        <button type="submit">Filtrar</button>
    </form>

    <!-- TABLA -->
    <table>
        <thead>
            <tr>
                <th>Hotel</th>
                <th>Reservas Admin</th>
                <th>Reservas Viajero</th>
                <th>Reservas Corporativo</th>
                <th>Comisión fija (€)</th>
                <th>Total comisiones (€)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($datos as $fila)
                <tr>
                    <td>{{ $fila->hotel }}</td>
                    <td>{{ $fila->reservas_admin }}</td>
                    <td>{{ $fila->reservas_viajero }}</td>
                    <td>{{ $fila->reservas_corporativo }} </td>
                    <td>{{ $fila->comision_hotel }} € </td>
                    <td class="total">
                        {{ number_format($fila->total_comisiones ?? 0, 2, ',', '.') }} €
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No hay datos para el mes seleccionado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <a href="{{ route('hotel.dashboard') }}" class="volver">
        Volver al panel
    </a>

</div>

</body>
</html>
