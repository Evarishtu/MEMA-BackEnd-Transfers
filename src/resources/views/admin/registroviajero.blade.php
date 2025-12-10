<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro Cliente Particular</title>

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

    .container {
      background: rgba(0, 0, 0, 0.25);
      padding: 40px;
      border-radius: 20px;
      width: 450px;
      backdrop-filter: blur(4px);
    }

    h2 {
      margin-top: 0;
      margin-bottom: 25px;
      font-size: 28px;
      text-align: center;
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

  <div class="container">

    <h2>🧑‍💼 Registro Cliente Particular</h2>

    <!-- FORMULARIO -->
    <form method="POST" action="{{ route('admin.viajero.store') }}">
      @csrf

      <!-- Mantener el flujo de la reserva -->
      <input type="hidden" name="tipo_reserva" value="{{ $tipo_reserva }}">

      <label>Email:</label>
      <input type="email" name="email" value="{{ $email_cliente }}" readonly>

      <label>Contraseña:</label>
      <input type="password" name="password" required>

      <label>Nombre:</label>
      <input type="text" name="nombre" required>

      <label>Primer apellido:</label>
      <input type="text" name="apellido1" required>

      <label>Segundo apellido:</label>
      <input type="text" name="apellido2">

      <label>Dirección:</label>
      <input type="text" name="direccion" required>

      <label>Código postal:</label>
      <input type="text" name="codigoPostal" required>

      <label>País:</label>
      <input type="text" name="pais" required>

      <label>Ciudad:</label>
      <input type="text" name="ciudad" required>

      <button type="submit">Registrar</button>
    </form>

    <a href="{{ route('admin.dashboard') }}" class="back">Volver al inicio</a>
  </div>

</body>
</html>