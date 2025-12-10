<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro Administrador</title>

  <style>
    body {
      margin: 0;
      font-family: "Arial", sans-serif;
      background: linear-gradient(135deg, #3a7bd5, #00d2ff);
      color: #fff;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      padding-top: 80px;
      min-height: 100vh;
    }

    .navbar {
      background: #ffffff;
      padding: 15px 40px;
      border-bottom-left-radius: 20px;
      border-bottom-right-radius: 20px;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      display: flex;
      align-items: center;
    }

    .navbar a {
      color: #2c3e50;
      text-decoration: none;
      font-weight: bold;
      font-size: 16px;
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .container {
      background: rgba(0, 0, 0, 0.25);
      padding: 40px;
      border-radius: 20px;
      width: 420px;
      backdrop-filter: blur(4px);
    }

    h2 {
      margin-top: 0;
      margin-bottom: 25px;
      font-size: 28px;
    }

    label {
      font-weight: bold;
      margin-top: 12px;
      display: block;
    }

    input {
      width: 100%;
      padding: 12px;
      border-radius: 10px;
      border: none;
      margin-top: 6px;
      margin-bottom: 18px;
      font-size: 15px;
    }

    button {
      width: 100%;
      padding: 12px;
      background: #3274ff;
      border: none;
      border-radius: 10px;
      color: #fff;
      font-size: 16px;
      cursor: pointer;
      font-weight: bold;
      margin-top: 10px;
    }

    button:hover {
      background: #195dff;
    }

    .back {
      display: block;
      text-align: center;
      margin-top: 15px;
      color: #aee3ff;
      text-decoration: none;
      font-weight: bold;
    }

    .back:hover {
      text-decoration: underline;
    }
  </style>
</head>

<body>

  <!-- NAVBAR -->
  <div class="navbar">
    <a href="{{ route('registro.index') }}">⬅️ Volver al inicio del registro</a>
  </div>

  <div class="container">

    <h2>🛡️ Registro Administrador</h2>

    <!-- BLOQUE DE ERRORES DE VALIDACIÓN -->
    @if ($errors->any())
      <div style="background: #ffdddd; color:#900; padding: 15px; 
                  border-radius: 10px; margin-bottom: 20px;">
        <strong>Por favor corrige los siguientes errores:</strong>
        <ul style="margin-top:10px; padding-left: 20px;">
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <!-- FORMULARIO -->
    <form method="POST" action="{{ route('registro.admin.store') }}">
      @csrf

      <input type="hidden" name="rol" value="admin">

      <label>Email:</label>
      <input type="email"
             name="email"
             placeholder="tu email"
             value="{{ old('email') }}"
             required>

      <label>Contraseña:</label>
      <input type="password"
             name="password"
             placeholder="mínimo 4 caracteres"
             required>

      <label>Nombre:</label>
      <input type="text"
             name="nombre"
             placeholder="tu nombre"
             value="{{ old('nombre') }}"
             required>

      <button type="submit">Registrar</button>
    </form>

    <a href="{{ route('registro.index') }}" class="back">⬅️ Volver al inicio</a>

  </div>

</body>
</html>
