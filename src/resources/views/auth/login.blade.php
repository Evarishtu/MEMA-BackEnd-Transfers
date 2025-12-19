<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Iniciar sesión</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
      justify-content: space-between;
      align-items: center;
    }

    .navbar .left a {
      color: #2c3e50;
      text-decoration: none;
      font-size: 16px;
      font-weight: bold;
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .navbar .right a {
      padding: 8px 16px;
      background: #3274ff;
      color: #fff;
      border-radius: 8px;
      text-decoration: none;
      font-size: 14px;
      margin-left: 8px;
      font-weight: bold;
      transition: 0.2s;
    }

    .navbar .right a:hover {
      background: #195dff;
    }

    .container {
      background: rgba(0, 0, 0, 0.25);
      padding: 40px;
      border-radius: 20px;
      width: 420px;
      backdrop-filter: blur(4px);
    }

    h1 {
      margin-top: 0;
      margin-bottom: 25px;
      font-size: 30px;
    }

    label {
      font-weight: bold;
      margin-top: 12px;
      display: block;
    }

    input, select {
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
      transition: 0.2s;
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

    .alert-error {
      background: rgba(255,0,0,0.3);
      padding: 10px;
      border-radius: 8px;
      text-align: center;
      font-weight: bold;
      color: #ffdddd;
      font-size: 15px;
      margin-bottom: 15px;
    }
  </style>
</head>
<body>

  <div class="navbar">
    <div class="left">
      <a href="{{ url('/') }}"><span>🏠</span> Volver al inicio</a>
    </div>
    <div class="right">
      <a href="{{ route('registro.index') }}">Registrarse</a>
    </div>
  </div>

  <div class="container">
    <h1>Iniciar sesión</h1>

    {{-- Mensaje de error desde el controlador (back()->with('error', true)) --}}
    @if(session('error'))
      <p class="alert-error">
        ❌ Usuario, contraseña o tipo de usuario incorrectos
      </p>
    @endif

    <form method="POST" action="{{ route('login.attempt') }}">
      @csrf

      <label>Usuario:</label>
      <input type="text" name="login" placeholder="tu usuario" required>

      <label>Contraseña:</label>
      <input type="password" name="password" placeholder="tu contraseña" required>

      <label>Tipo de usuario:</label>
      <select name="rol" required>
        <option value="viajero">Cliente particular</option>
        <option value="hotel">Cliente corporativo (Hotel)</option>
        <option value="admin">Administrador</option>
      </select>

      <button type="submit">Entrar</button>
    </form>

    <a href="{{ url('/') }}" class="back">⬅️ Volver a la página principal</a>
  </div>

</body>
</html>
