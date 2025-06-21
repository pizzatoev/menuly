<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Menuly | Gestiona tu carrito</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- NAVBAR --> 
<nav class="navbar navbar-expand-lg bg-menuly">
  <div class="container">
    <a class="navbar-brand text-white fw-bold" style="font-size: 3rem;" href="#">Menuly</a>

    <button class="navbar-toggler text-white border-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 gap-3 fs-5">
        <li class="nav-item"><a class="nav-link text-white" href="#caracteristicas">Características</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="#beneficios">Beneficios</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="#planes">Planes</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="#contacto">Contacto</a></li>
      </ul>
      <div class="d-flex ms-3 gap-2">
  <a href="{{ route('login.view') }}" class="btn btn-outline-light fw-semibold btn-lg">
    Iniciar sesión
  </a>
  
  <button class="btn btn-light text-menuly fw-semibold btn-lg" data-bs-toggle="modal" data-bs-target="#registroModal">
    Registrarse
  </button>
</div>


    </div>
  </div>
</nav>

<!-- HERO SLIDER SECTION -->
<section class="hero-section text-white">
  <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">

      <!-- Slide 1 -->
      <div class="carousel-item active bg-menuly hero-slide">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
              <h1 class="display-5 fw-bold">¡Digitaliza tu carrito de comida en minutos!</h1>
              <p class="lead">Fácil, rápido y desde cualquier dispositivo.</p>
              <button class="btn btn-light text-menuly fw-semibold" data-bs-toggle="modal" data-bs-target="#registroModal">
                Comienza gratis
              </button>
            </div>
            <div class="col-md-6 text-center">
              <img src="{{ asset('foto/foto.png') }}" class="img-fluid" alt="Sistema Menuly">
            </div>
          </div>
        </div>
      </div>

      <!-- Slide 2 -->
      <div class="carousel-item bg-menuly hero-slide">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
              <h1 class="display-5 fw-bold">Lleva el control de ventas, gastos y stock</h1>
              <p class="lead">Todo desde la palma de tu mano.</p>
              <button class="btn btn-light text-menuly fw-semibold" data-bs-toggle="modal" data-bs-target="#registroModal">
                Comienza gratis
              </button>
            </div>
            <div class="col-md-6 text-center">
              <img src="{{ asset('foto/pc.png') }}" class="img-fluid" alt="Sistema Menuly">
            </div>
          </div>
        </div>
      </div>

      <!-- Slide 3 -->
      <div class="carousel-item bg-menuly hero-slide">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
              <h1 class="display-5 fw-bold">Gestiona varios carritos desde un solo panel</h1>
              <p class="lead">Escalable, profesional y sin complicaciones.</p>
              <button class="btn btn-light text-menuly fw-semibold" data-bs-toggle="modal" data-bs-target="#registroModal">
                Comienza gratis
              </button>
            </div>
            <div class="col-md-6 text-center">
              <img src="{{ asset('foto/pccel.png') }}" class="img-fluid" alt="Sistema Menuly">
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Controles del slider -->
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>
  </div>
</section>


<!-- CARACTERISTICAS -->
<section id="caracteristicas" class="py-5 bg-light text-center">
  <div class="container">
    <h2 class="mb-4 fw-bold">Un aliado para tu negocio</h2>
    <div class="row">
      <div class="col-md-2 offset-md-1">
        <div class="p-3 icon-box">
          <i class="bi bi-cart4 display-6 text-danger"></i>
          <h6 class="mt-3">Registro de ventas</h6>
        </div>
      </div>
      <div class="col-md-2">
        <div class="p-3 icon-box">
          <i class="bi bi-box-seam display-6 text-danger"></i>
          <h6 class="mt-3">Control de stock</h6>
        </div>
      </div>
      <div class="col-md-2">
        <div class="p-3 icon-box">
          <i class="bi bi-gift display-6 text-danger"></i>
          <h6 class="mt-3">Promociones y combos</h6>
        </div>
      </div>
      <div class="col-md-2">
        <div class="p-3 icon-box">
          <i class="bi bi-hdd-stack display-6 text-danger"></i>
          <h6 class="mt-3">Panel multi-carrito</h6>
        </div>
      </div>
      <div class="col-md-2">
        <div class="p-3 icon-box">
          <i class="bi bi-printer-fill display-6 text-danger"></i>
          <h6 class="mt-3">Reportes imprimibles</h6>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- BENEFICIOS DESTACADOS -->
<section id="beneficios" class="py-5 text-center">
  <div class="container">
    <h2 class="mb-4 fw-bold">Beneficios clave de Menuly</h2>
    <div class="row g-4">
      <div class="col-md-3">
        <div class="p-4 border rounded-4 h-100 shadow-sm">
          <i class="bi bi-clock-history display-5 text-danger"></i>
          <h5 class="mt-3">Ahorro de tiempo</h5>
          <p class="small">Registra ventas y gestiona inventario en segundos desde cualquier dispositivo.</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="p-4 border rounded-4 h-100 shadow-sm">
          <i class="bi bi-speedometer2 display-5 text-danger"></i>
          <h5 class="mt-3">Mayor control</h5>
          <p class="small">Accede a reportes, stock, ventas y gastos desde un solo panel centralizado.</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="p-4 border rounded-4 h-100 shadow-sm">
          <i class="bi bi-phone display-5 text-danger"></i>
          <h5 class="mt-3">Fácil en celulares</h5>
          <p class="small">Diseñado para pantallas pequeñas, ideal para cajeros o vendedores en movimiento.</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="p-4 border rounded-4 h-100 shadow-sm">
          <i class="bi bi-columns-gap display-5 text-danger"></i>
          <h5 class="mt-3">Escalable</h5>
          <p class="small">Gestiona uno o varios carritos desde un solo sistema sin complicaciones.</p>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- TESTIMONIOS -->
<section class="py-5 bg-light text-center">
  <div class="container">
    <h2 class="mb-5 fw-bold">Lo que opinan nuestros usuarios</h2>
    <div class="row justify-content-center">
      
      <!-- Testimonio 1 -->
      <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm p-4 h-100">
          <p class="fst-italic">"Menuly me ayudó a organizar mi carrito. Ahora vendo más y más rápido."</p>
          <h6 class="fw-bold mb-0">Carlos Rojas</h6>
          <small class="text-muted">Santa Cruz, Bolivia</small>
        </div>
      </div>

      <!-- Testimonio 2 -->
      <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm p-4 h-100">
          <p class="fst-italic">"Fácil de usar incluso desde mi celular. Lo recomiendo para cualquier emprendedor."</p>
          <h6 class="fw-bold mb-0">María Fernández</h6>
          <small class="text-muted">Cochabamba, Bolivia</small>
        </div>
      </div>

      <!-- Testimonio 3 -->
      <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm p-4 h-100">
          <p class="fst-italic">"Controlar varios carritos desde un solo lugar me ahorra muchísimo trabajo."</p>
          <h6 class="fw-bold mb-0">Jorge Mamani</h6>
          <small class="text-muted">La Paz, Bolivia</small>
        </div>
      </div>

    </div>
  </div>
</section>
<!-- PLANES DISPONIBLES -->
<section id="planes" class="py-5 text-center">
  <div class="container">
    <h2 class="mb-5 fw-bold">Elige tu plan ideal</h2>
    <div class="row justify-content-center">

      <!-- Plan Gratis -->
      <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm border-2 border-danger">
          <div class="card-header bg-menuly text-white fw-bold">
            Plan Gratis
          </div>
          <div class="card-body">
            <h3 class="card-title">Bs. 0</h3>
            <p class="card-text">Ideal para comenzar. Funcionalidades limitadas pero suficientes para probar Menuly.</p>
            <ul class="list-unstyled small text-start">
              <li>✔ Registro de ventas</li>
              <li>✔ Control básico de stock</li>
              <li>✖ Promociones y combos</li>
              <li>✖ Multi-carrito</li>
            </ul>
            <a data-bs-toggle="modal" data-bs-target="#registroModal" class="btn btn-menuly w-100 mt-3">Comenzar</a>
          </div>
        </div>
      </div>

      <!-- Plan Pro -->
      <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm">
          <div class="card-header bg-danger text-white fw-bold">
            Plan Pro
          </div>
          <div class="card-body">
            <h3 class="card-title">Bs. 49 / mes</h3>
            <p class="card-text">Pensado para negocios en crecimiento que requieren más control y funciones avanzadas.</p>
            <ul class="list-unstyled small text-start">
              <li>✔ Todo lo del plan Gratis</li>
              <li>✔ Promociones y combos</li>
              <li>✔ Reportes descargables</li>
              <li>✖ Multi-carrito</li>
            </ul>
            <a data-bs-toggle="modal" data-bs-target="#registroModal" class="btn btn-menuly w-100 mt-3">Comenzar</a>
          </div>
        </div>
      </div>

      <!-- Plan Empresarial -->
      <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm border-2 border-dark">
          <div class="card-header bg-dark text-white fw-bold">
            Plan Empresarial
          </div>
          <div class="card-body">
            <h3 class="card-title">Bs. 99 / mes</h3>
            <p class="card-text">Para quienes gestionan varios carritos y necesitan una solución completa y escalable.</p>
            <ul class="list-unstyled small text-start">
              <li>✔ Todas las funciones Pro</li>
              <li>✔ Panel multi-carrito</li>
              <li>✔ Gestión de usuarios</li>
              <li>✔ Soporte prioritario</li>
            </ul>
            <a data-bs-toggle="modal" data-bs-target="#registroModal" class="btn btn-menuly w-100 mt-3">Comenzar</a>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- LLAMADO A LA ACCIÓN -->
<section class="py-5 bg-menuly text-white text-center">
  <div class="container">
    <h2 class="fw-bold mb-4">¿Listo para transformar tu carrito?</h2>
    <p class="lead mb-4">Comienza hoy mismo con Menuly y lleva el control total desde la palma de tu mano.</p>
    <button class="btn btn-light text-menuly fw-semibold" data-bs-toggle="modal" data-bs-target="#registroModal">
      Registrarse
    </button>
  </div>
</section>

<!-- FORMAS DE PAGO -->
<section class="py-5 bg-light text-center">
  <div class="container">
    <h2 class="fw-bold mb-4">Formas de pago aceptadas</h2>
    <div class="row justify-content-center g-4">

      <div class="col-6 col-md-3">
        <div class="p-3 border rounded-3 shadow-sm h-100">
          <i class="bi bi-phone display-4 text-danger"></i>
          <h6 class="mt-3">Tigo Money</h6>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="p-3 border rounded-3 shadow-sm h-100">
          <i class="bi bi-qr-code-scan display-4 text-danger"></i>
          <h6 class="mt-3">Pago QR</h6>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="p-3 border rounded-3 shadow-sm h-100">
          <i class="bi bi-credit-card display-4 text-danger"></i>
          <h6 class="mt-3">Tarjeta</h6>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="p-3 border rounded-3 shadow-sm h-100">
          <i class="bi bi-cash-coin display-4 text-danger"></i>
          <h6 class="mt-3">Efectivo</h6>
        </div>
      </div>

    </div>
    
  </div>
</section>

<!-- CONTACTO -->
<section id="contacto" class="py-5 text-center">
  <div class="container">
    <h2 class="fw-bold mb-4">¿Tienes preguntas o quieres hablar con nosotros?</h2>
    <p class="mb-5">Contáctanos por cualquiera de nuestros canales:</p>

    <div class="row justify-content-center g-4">
      <!-- WhatsApp -->
      <div class="col-6 col-md-3">
        <a href="https://wa.me/59171234567" target="_blank" class="text-decoration-none">
          <div class="p-4 border rounded-4 shadow-sm h-100">
            <i class="bi bi-whatsapp display-4 text-success"></i>
            <h6 class="mt-3 text-dark">WhatsApp</h6>
            <small class="text-muted">+591 71234567</small>
          </div>
        </a>
      </div>

      <!-- Instagram -->
      <div class="col-6 col-md-3">
        <a href="https://www.instagram.com/menuly.bo" target="_blank" class="text-decoration-none">
          <div class="p-4 border rounded-4 shadow-sm h-100">
            <i class="bi bi-instagram display-4" style="color:#e1306c;"></i>
            <h6 class="mt-3 text-dark">Instagram</h6>
            <small class="text-muted">@menuly.bo</small>
          </div>
        </a>
      </div>

      <!-- Facebook -->
      <div class="col-6 col-md-3">
        <a href="https://www.facebook.com/menuly.bo" target="_blank" class="text-decoration-none">
          <div class="p-4 border rounded-4 shadow-sm h-100">
            <i class="bi bi-facebook display-4 text-primary"></i>
            <h6 class="mt-3 text-dark">Facebook</h6>
            <small class="text-muted">/menuly.bo</small>
          </div>
        </a>
      </div>

      <!-- Email -->
      <div class="col-6 col-md-3">
        <a href="mailto:contacto@menuly.bo" class="text-decoration-none">
          <div class="p-4 border rounded-4 shadow-sm h-100">
            <i class="bi bi-envelope-fill display-4 text-danger"></i>
            <h6 class="mt-3 text-dark">Correo</h6>
            <small class="text-muted">contacto@menuly.bo</small>
          </div>
        </a>
      </div>
    </div>
  </div>
</section>


<!-- MODAL DE REGISTRO -->
<div class="modal fade" id="registroModal" tabindex="-1" aria-labelledby="registroModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content rounded-4 shadow-lg p-4" method="POST" action="{{ route('registrar.usuario') }}">
    @csrf
    <div class="modal-header bg-menuly text-white border-0 rounded-top-4">
        <h5 class="modal-title w-100 text-center fw-bold" id="registroModalLabel">Crear cuenta en Menuly</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
    </div>
    <div class="modal-body">
        <div class="mb-3">
            <label for="nombre" class="form-label fw-semibold">Nombre completo</label>
            <input type="text" class="form-control form-control-lg" id="nombre" name="nombre" required>
        </div>
        <div class="mb-3">
            <label for="correo" class="form-label fw-semibold">Correo electrónico</label>
            <input type="email" class="form-control form-control-lg" id="correo" name="correo" required>
        </div>
        <div class="mb-3">
            <label for="contrasena" class="form-label fw-semibold">Contraseña</label>
            <input type="password" class="form-control form-control-lg" id="contrasena" name="contrasena" required>
        </div>
        <div class="mb-3">
            <label for="rol" class="form-label fw-semibold">Rol</label>
            <select class="form-control form-control-lg" id="rol" name="rol" required>
                <option value="Admin">Admin</option>
                <option value="Cajero">Cajero</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="id_carrito" class="form-label fw-semibold">ID del carrito</label>
            <input type="number" class="form-control form-control-lg" id="id_carrito" name="id_carrito" required>
        </div>
    </div>
    <div class="modal-footer border-0">
        <button type="submit" class="btn btn-menuly btn-lg w-100">Registrarme</button>
    </div>
</form>
  </div>
</div>


<footer class="text-center text-white py-3 bg-menuly">
  <small>&copy; 2025 Menuly - Todos los derechos reservados</small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>