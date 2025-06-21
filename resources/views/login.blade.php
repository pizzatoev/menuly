<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Iniciar sesión - Menuly</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>
<body class="bg-light">

  <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow-lg p-4 rounded-4" style="width: 100%; max-width: 450px;">
      <div class="card-header bg-menuly text-white text-center rounded-3 mb-4">
        <h4 class="fw-bold my-2">Iniciar sesión</h4>
      </div>

      <form method="POST" action="{{ route('login') }}">
        @csrf

        @if(session('error'))
          <div class="alert alert-danger">
            {{ session('error') }}
          </div>
        @endif

        <div class="mb-3">
          <label for="correo" class="form-label fw-semibold">Correo electrónico</label>
          <input type="email" class="form-control form-control-lg" id="correo" name="correo" required autofocus>
        </div>

        <div class="mb-3">
          <label for="contrasena" class="form-label fw-semibold">Contraseña</label>
          <input type="password" class="form-control form-control-lg" id="contrasena" name="contrasena" required>
        </div>

        <div class="d-grid">
          <button type="submit" class="btn btn-menuly btn-lg fw-semibold">Entrar</button>
        </div>
      </form>

      <div class="text-center mt-3">
        <a href="{{ url('/') }}" class="text-decoration-none text-menuly">← Volver a inicio</a>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
