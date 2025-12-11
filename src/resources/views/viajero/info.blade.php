@extends('layouts.app')

@section('content')

<style>
    body {
        margin: 0;
        font-family: "Arial", sans-serif;
        background: linear-gradient(135deg, #3a7bd5, #00d2ff);
        color: #fff;
        display: flex;
        justify-content: center;
        padding-top: 120px;
        padding-bottom: 60px;
        min-height: 100vh;
    }

    .card {
        width: 90%;
        max-width: 650px;
        background: rgba(255, 255, 255, 0.35);
        backdrop-filter: blur(10px);
        border-radius: 18px;
        padding: 35px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        color: #fff;
    }

    h1 {
        text-align: center;
        margin-top: 0;
        font-size: 32px;
        margin-bottom: 25px;
    }

    label {
        display: block;
        margin-top: 12px;
        font-weight: bold;
    }

    input {
        margin-top: 6px;
        width: 100%;
        padding: 12px;
        border-radius: 10px;
        border: none;
        outline: none;
        font-size: 15px;
    }

    .toggle-btn {
        margin-top: 10px;
        padding: 10px 14px;
        border: none;
        border-radius: 10px;
        background: #6c757d;
        color: white;
        cursor: pointer;
        width: 100%;
        font-size: 14px;
        font-weight: bold;
    }

    .toggle-btn:hover {
        background: #565e64;
    }

    button {
        margin-top: 20px;
        padding: 14px;
        width: 100%;
        background: #1f8fff;
        color: #fff;
        border: none;
        border-radius: 12px;
        cursor: pointer;
        font-size: 17px;
        font-weight: bold;
        transition: 0.3s;
    }

    button:hover {
        background: #0066cc;
    }

    .disabled input {
        background: rgba(255,255,255,0.4);
        pointer-events: none;
    }

    a.back {
        display: block;
        text-align: center;
        margin-top: 20px;
        text-decoration: none;
        font-size: 16px;
        color: #e5f3ff;
        font-weight: bold;
    }

    a.back:hover {
        text-decoration: underline;
    }
</style>


<div class="card">
    <h1>👤 Información Personal</h1>

    {{-- MENSAJE DE ÉXITO --}}
    @if(session('success'))
        <div style="padding:12px;background:#28a745;border-radius:8px;margin-bottom:20px;">
            {{ session('success') }}
        </div>
    @endif

    <form id="infoForm" 
          method="POST" 
          action="{{ route('viajero.info.update') }}" 
          class="disabled">

        @csrf
        @method('PUT')

        <input type="hidden" name="id_viajero" value="{{ $viajero->id_viajero }}">

        <label>Nombre:</label>
        <input type="text" name="nombre" value="{{ $viajero->nombre }}">

        <label>Primer apellido:</label>
        <input type="text" name="apellido1" value="{{ $viajero->apellido1 }}">

        <label>Segundo apellido:</label>
        <input type="text" name="apellido2" value="{{ $viajero->apellido2 }}">

        <label>Email:</label>
        <input type="email" name="email" value="{{ $viajero->email }}" readonly>

        <label>Dirección:</label>
        <input type="text" name="direccion" value="{{ $viajero->direccion }}">

        <label>Código postal:</label>
        <input type="text" name="codigoPostal" value="{{ $viajero->codigoPostal }}">

        <label>País:</label>
        <input type="text" name="pais" value="{{ $viajero->pais }}">

        <label>Ciudad:</label>
        <input type="text" name="ciudad" value="{{ $viajero->ciudad }}">

        <label>Contraseña:</label>
        <input type="password" id="passwordField" name="password" placeholder="Escribe nueva contraseña:" disabled>

        <button type="button" class="toggle-btn" id="togglePassword" disabled>
            Mostrar contraseña
        </button>

        <button type="button" id="editarBtn">Editar</button>
        <button type="submit" id="guardarBtn" style="display:none;">Guardar</button>

    </form>

    <a class="back" href="{{ route('viajero.dashboard') }}">← Volver al dashboard</a>
</div>


<script>
    const form = document.getElementById('infoForm');
    const editarBtn = document.getElementById('editarBtn');
    const guardarBtn = document.getElementById('guardarBtn');

    const passwordField = document.getElementById('passwordField');
    const togglePassword = document.getElementById('togglePassword');

    editarBtn.addEventListener('click', () => {
        form.classList.remove('disabled');

        passwordField.disabled = false;
        togglePassword.disabled = false;

        editarBtn.style.display = 'none';
        guardarBtn.style.display = 'inline-block';
    });

    togglePassword.addEventListener('click', () => {
        if (passwordField.type === "password") {
            passwordField.type = "text";
            togglePassword.textContent = "Ocultar contraseña";
        } else {
            passwordField.type = "password";
            togglePassword.textContent = "Mostrar contraseña";
        }
    });
</script>

@endsection