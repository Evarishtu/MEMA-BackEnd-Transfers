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
        max-width: 700px;
        margin: auto;
        background: rgba(255, 255, 255, 0.30);
        backdrop-filter: blur(10px);
        padding: 35px;
        border-radius: 18px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    h1 {
        text-align: center;
        margin-top: 0;
        margin-bottom: 25px;
        font-size: 30px;
        color: #e7ffe7;
    }

    h2 {
        margin-top: 25px;
        color: #003b63;
        font-size: 24px;
        font-weight: bold;
    }

    .localizador-box {
        background: rgba(255, 255, 255, 0.55);
        padding: 15px 18px;
        border-left: 4px solid #f1c40f;
        border-radius: 10px;
        font-size: 18px;
        color: #003b63;
        font-weight: bold;
        margin-bottom: 20px;
    }

    ul {
        background: rgba(255, 255, 255, 0.45);
        padding: 15px 20px;
        border-radius: 10px;
        border-left: 4px solid #2ecc71;
        list-style: none;
        color: #003b63;
        font-weight: bold;
    }

    ul li {
        margin-bottom: 8px;
        font-size: 16px;
    }

    .email-box {
        background: rgba(255, 255, 255, 0.50);
        border-left: 4px solid #3498db;
        padding: 14px 18px;
        border-radius: 10px;
        margin-top: 22px;
        color: #003b63;
        font-weight: bold;
    }

    .btn-return {
        display: inline-block;
        margin-top: 35px;
        background: #004a80;
        color: white;
        padding: 12px 22px;
        text-decoration: none;
        border-radius: 10px;
        font-size: 16px;
        transition: 0.2s;
        text-align: center;
    }

    .btn-return:hover {
        background: #00345a;
    }
</style>

<div class="card">

    <h1>Reserva creada correctamente</h1>

    <div class="localizador-box">
        <strong>Localizador:</strong> {{ $localizador }}
    </div>

    <h2>Detalles de la reserva</h2>

    <ul>
        <li><strong>Tipo de trayecto:</strong> {{ $tipo_reserva_texto }}</li>
        <li><strong>Hotel:</strong> {{ $hotel_nombre }}</li>
        <li><strong>Número de viajeros:</strong> {{ $num_viajeros }}</li>
    </ul>

    <div class="email-box">
        Se ha enviado un correo electrónico con los detalles de la reserva a:<br>
        <strong>{{ $email }}</strong>
    </div>

    <a class="btn-return" href="{{ route('viajero.dashboard') }}">← Volver al panel</a>

</div>

@endsection