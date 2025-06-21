<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Menuly</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            display: flex;
            height: 100vh;
            margin: 0;
        }

        .sidebar {
            width: 280px;
            background-color: #b91c1c;
            color: white;
            padding: 20px 10px;
            display: flex;
            flex-direction: column;
        }

        .sidebar h3 {
            font-weight: bold;
            margin-bottom: 30px;
            text-align: center;
            font-size: 1.2rem;
        }

        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            color: white;
            text-decoration: none;
            margin-bottom: 25px;
            padding: 15px 10px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .nav-item:hover {
            background-color: #dc2626;
            color: white;
            text-decoration: none;
            transform: translateY(-2px);
        }

        .nav-item.active {
            background-color: #dc2626;
        }

        .nav-item i {
            font-size: 24px;
            margin-bottom: 8px;
        }

        .nav-item span {
            font-size: 13px;
            font-weight: 600;
            text-align: center;
        }

        .content {
            flex: 1;
            padding: 40px;
            background-color: #f8fafc;
            overflow-y: auto;
        }

        .logout-section {
            margin-top: auto;
            padding-top: 20px;
        }

        /* Estilos para el dashboard */
        .dashboard-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            padding: 25px;
            color: white;
            margin-bottom: 25px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
        }

        .dashboard-card.sales {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }

        .dashboard-card.clients {
            background: linear-gradient(135deg, #ff6b6b 0%, #feca57 100%);
        }

        .dashboard-card.products {
            background: linear-gradient(135deg, #3742fa 0%, #2f3542 100%);
        }

        .dashboard-card.expenses {
            background: linear-gradient(135deg, #ff9ff3 0%, #f368e0 100%);
        }

        .card-icon {
            font-size: 48px;
            margin-bottom: 15px;
        }

        .card-value {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .card-label {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .welcome-section {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h3>Menuly {{ Auth::user()->rol }}</h3>

        <a class="nav-item" onclick="cargarSeccion('dashboard')" id="nav-dashboard">
            <i class="bi bi-house-door"></i>
            <span>Dashboard</span>
        </a>

        @if(Auth::user()->rol === 'Admin')
            <a class="nav-item" onclick="cargarSeccion('productos')" id="nav-productos">
                <i class="bi bi-box-seam"></i>
                <span>Productos</span>
            </a>
        @endif
        
        <a class="nav-item" onclick="cargarSeccion('ventas')" id="nav-ventas">
            <i class="bi bi-cart-check"></i>
            <span>Ventas</span>
        </a>

        <a class="nav-item" onclick="cargarSeccion('clientes')" id="nav-clientes">
            <i class="bi bi-people"></i>
            <span>Clientes</span>
        </a>

        @if(Auth::user()->rol === 'Admin')
            <a class="nav-item" onclick="cargarSeccion('transacciones')" id="nav-transacciones">
                <i class="bi bi-credit-card"></i>
                <span>Transacciones</span>
            </a>
        @endif

        <div class="logout-section">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-light text-dark fw-semibold w-100">
                    <i class="bi bi-box-arrow-right me-2"></i>Cerrar sesión
                </button>
            </form>
        </div>
    </div>

    <!-- Contenido principal -->
    <div class="content">
        <div id="contenido">
            <!-- Dashboard inicial -->
            <div class="welcome-section">
                <h2 class="fw-bold mb-2">Bienvenido, {{ Auth::user()->nombre }}</h2>
                <p class="text-muted mb-0">Panel de {{ Auth::user()->rol === 'Admin' ? 'administración' : 'cajero' }}</p>
            </div>

            @if(Auth::user()->rol === 'Admin')
                <!-- Dashboard para Admin -->
                <div class="row">
                    <div class="col-md-6 col-lg-3">
                        <div class="dashboard-card sales">
                            <div class="text-center">
                                <i class="bi bi-currency-dollar card-icon"></i>
                                <div class="card-value" id="ventas-dinero">Bs 0.00</div>
                                <div class="card-label">Ventas Hoy</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="dashboard-card clients">
                            <div class="text-center">
                                <i class="bi bi-cart3 card-icon"></i>
                                <div class="card-value" id="cantidad-ventas">0</div>
                                <div class="card-label">Pedidos Hoy</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="dashboard-card products">
                            <div class="text-center">
                                <i class="bi bi-people-fill card-icon"></i>
                                <div class="card-value" id="clientes-nuevos">0</div>
                                <div class="card-label">Clientes Nuevos</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="dashboard-card expenses">
                            <div class="text-center">
                                <i class="bi bi-credit-card-2-front card-icon"></i>
                                <div class="card-value" id="gastos-hoy">Bs 0.00</div>
                                <div class="card-label">Gastos Hoy</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="bi bi-graph-up me-2"></i>Resumen del Mes</h5>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-6">
                                        <h4 class="text-success" id="ventas-mes">Bs 0.00</h4>
                                        <small class="text-muted">Ventas del Mes</small>
                                    </div>
                                    <div class="col-6">
                                        <h4 class="text-info" id="productos-stock">0</h4>
                                        <small class="text-muted">Productos en Stock</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-warning text-dark">
                                <h5 class="mb-0"><i class="bi bi-exclamation-triangle me-2"></i>Alertas</h5>
                            </div>
                            <div class="card-body">
                                <div id="productos-bajo-stock">
                                    <p class="text-muted">Cargando productos con stock bajo...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Dashboard para Cajero -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="dashboard-card sales">
                            <div class="text-center">
                                <i class="bi bi-currency-dollar card-icon"></i>
                                <div class="card-value" id="ventas-dinero">Bs 0.00</div>
                                <div class="card-label">Ventas Hoy</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="dashboard-card clients">
                            <div class="text-center">
                                <i class="bi bi-cart3 card-icon"></i>
                                <div class="card-value" id="cantidad-ventas">0</div>
                                <div class="card-label">Pedidos Hoy</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Función para cargar estadísticas del dashboard
        function cargarEstadisticas() {
            fetch('/estadisticas-dashboard', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                // Actualizar valores en el dashboard
                document.getElementById('ventas-dinero').textContent = `Bs ${data.ventasHoy}`;
                document.getElementById('cantidad-ventas').textContent = data.cantidadVentas;
                
                @if(Auth::user()->rol === 'Admin')
                    document.getElementById('clientes-nuevos').textContent = data.clientesNuevos;
                    document.getElementById('gastos-hoy').textContent = `Bs ${data.gastosHoy}`;
                    document.getElementById('ventas-mes').textContent = `Bs ${data.ventasMes}`;
                    document.getElementById('productos-stock').textContent = data.totalProductos;
                    
                    // Productos con stock bajo
                    const stockBajoHtml = data.productosBajoStock.length > 0 
                        ? data.productosBajoStock.map(p => 
                            `<div class="alert alert-warning py-2 mb-2">
                                <small><strong>${p.nombre}</strong>: ${p.stock} unidades</small>
                            </div>`
                          ).join('')
                        : '<p class="text-success mb-0"><i class="bi bi-check-circle me-2"></i>Todos los productos tienen stock suficiente</p>';
                    
                    document.getElementById('productos-bajo-stock').innerHTML = stockBajoHtml;
                @endif
            })
            .catch(error => {
                console.error('Error al cargar estadísticas:', error);
            });
        }

        // Función global para cargar secciones
        function cargarSeccion(nombre, id = null) {
            // Remover clase active de todos los nav-items
            document.querySelectorAll('.nav-item').forEach(item => {
                item.classList.remove('active');
            });

            // Agregar clase active al nav-item seleccionado
            const navItem = document.getElementById('nav-' + nombre);
            if (navItem) {
                navItem.classList.add('active');
            }

            if (nombre === 'dashboard') {
                // Mostrar dashboard y cargar estadísticas
                document.getElementById("contenido").innerHTML = `
                    <div class="welcome-section">
                        <h2 class="fw-bold mb-2">Bienvenido, {{ Auth::user()->nombre }}</h2>
                        <p class="text-muted mb-0">Panel de {{ Auth::user()->rol === 'Admin' ? 'administración' : 'cajero' }}</p>
                    </div>

                    @if(Auth::user()->rol === 'Admin')
                        <div class="row">
                            <div class="col-md-6 col-lg-3">
                                <div class="dashboard-card sales">
                                    <div class="text-center">
                                        <i class="bi bi-currency-dollar card-icon"></i>
                                        <div class="card-value" id="ventas-dinero">Bs 0.00</div>
                                        <div class="card-label">Ventas Hoy</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="dashboard-card clients">
                                    <div class="text-center">
                                        <i class="bi bi-cart3 card-icon"></i>
                                        <div class="card-value" id="cantidad-ventas">0</div>
                                        <div class="card-label">Pedidos Hoy</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="dashboard-card products">
                                    <div class="text-center">
                                        <i class="bi bi-people-fill card-icon"></i>
                                        <div class="card-value" id="clientes-nuevos">0</div>
                                        <div class="card-label">Clientes Nuevos</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="dashboard-card expenses">
                                    <div class="text-center">
                                        <i class="bi bi-credit-card-2-front card-icon"></i>
                                        <div class="card-value" id="gastos-hoy">Bs 0.00</div>
                                        <div class="card-label">Gastos Hoy</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="mb-0"><i class="bi bi-graph-up me-2"></i>Resumen del Mes</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row text-center">
                                            <div class="col-6">
                                                <h4 class="text-success" id="ventas-mes">Bs 0.00</h4>
                                                <small class="text-muted">Ventas del Mes</small>
                                            </div>
                                            <div class="col-6">
                                                <h4 class="text-info" id="productos-stock">0</h4>
                                                <small class="text-muted">Productos en Stock</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header bg-warning text-dark">
                                        <h5 class="mb-0"><i class="bi bi-exclamation-triangle me-2"></i>Alertas</h5>
                                    </div>
                                    <div class="card-body">
                                        <div id="productos-bajo-stock">
                                            <p class="text-muted">Cargando productos con stock bajo...</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="row">
                            <div class="col-md-6">
                                <div class="dashboard-card sales">
                                    <div class="text-center">
                                        <i class="bi bi-currency-dollar card-icon"></i>
                                        <div class="card-value" id="ventas-dinero">Bs 0.00</div>
                                        <div class="card-label">Ventas Hoy</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="dashboard-card clients">
                                    <div class="text-center">
                                        <i class="bi bi-cart3 card-icon"></i>
                                        <div class="card-value" id="cantidad-ventas">0</div>
                                        <div class="card-label">Pedidos Hoy</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                `;
                cargarEstadisticas();
                return;
            }

            let url = `/seccion/${nombre}`;
            if (id) {
                url += `?id=${id}`;
            }

            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.text().then(text => { 
                        throw new Error(text || 'Error al cargar la sección.'); 
                    });
                }
                return response.text();
            })
            .then(html => {
                document.getElementById("contenido").innerHTML = html;
                
                // Si hay scripts en el contenido cargado, los ejecutamos
                const scripts = document.getElementById("contenido").querySelectorAll("script");
                scripts.forEach(script => {
                    const newScript = document.createElement("script");
                    newScript.text = script.innerText;
                    document.body.appendChild(newScript).parentNode.removeChild(newScript);
                });
            })
            .catch(error => {
                console.error('Error detallado:', error);
                document.getElementById("contenido").innerHTML = `<div class="alert alert-danger">Error al cargar la sección. Revise la consola para más detalles.</div>`;
            });
        }

        // Cargar estadísticas al iniciar
        document.addEventListener('DOMContentLoaded', function() {
            // Activar dashboard por defecto
            document.getElementById('nav-dashboard').classList.add('active');
            cargarEstadisticas();
        });

        // Delegación para el formulario de productos
        document.addEventListener('submit', function(e) {
            if (e.target && e.target.id === 'form-producto') {
                e.preventDefault();
                const form = e.target;
                const data = new FormData(form);

                fetch("/productos", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: data
                })
                .then(res => {
                    if (!res.ok) throw new Error("Error al guardar producto");
                    return res.json();
                })
                .then(() => {
                    document.getElementById('mensaje').innerHTML = `
                        <div class="alert alert-success">Producto registrado correctamente</div>`;
                    form.reset();
                    cargarSeccion('productos');
                })
                .catch(err => {
                    document.getElementById('mensaje').innerHTML = `
                        <div class="alert alert-danger">${err.message}</div>`;
                });
            }
        });

        // Delegación para eliminar productos (solo visible para Admin)
        @if(Auth::user()->rol === 'Admin')
        document.addEventListener('click', function(e) {
            if (
                e.target.classList.contains('btn-danger') &&
                e.target.textContent.trim() === 'Eliminar'
            ) {
                e.preventDefault();
                const fila = e.target.closest('tr');
                const id = fila ? fila.querySelector('td').textContent.trim() : null;
                if (!id) {
                    alert('No se pudo obtener el ID del producto.');
                    return;
                }
                if (!confirm('¿Estás seguro de eliminar este producto?')) return;

                fetch(`/productos/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(res => {
                    if (!res.ok) throw new Error('Error al eliminar producto');
                    return res.json();
                })
                .then(() => {
                    cargarSeccion('productos');
                })
                .catch(error => {
                    alert(error.message);
                });
            }
        });

        // Delegación para el botón "Modificar" y edición en línea (solo visible para Admin)
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('btn-editar')) {
                const fila = e.target.closest('tr');
                if (!fila) return;

                if (fila.classList.contains('editando')) return;

                fila.classList.add('editando');

                const tds = fila.querySelectorAll('td');
                const id = tds[0].textContent.trim();
                const nombre = tds[1].textContent.trim();
                const precio = tds[2].textContent.trim();
                const stock = tds[3].textContent.trim();

                tds[1].innerHTML = `<input type="text" class="form-control form-control-sm" value="${nombre}">`;
                tds[2].innerHTML = `<input type="number" class="form-control form-control-sm" value="${precio}" step="0.01">`;
                tds[3].innerHTML = `<input type="number" class="form-control form-control-sm" value="${stock}">`;

                tds[4].innerHTML = `
                    <button class="btn btn-sm btn-success btn-guardar">Guardar</button>
                    <button class="btn btn-sm btn-secondary btn-cancelar">Cancelar</button>
                `;
            }

            if (e.target.classList.contains('btn-guardar')) {
                const fila = e.target.closest('tr');
                const tds = fila.querySelectorAll('td');
                const id = tds[0].textContent.trim();
                const nombre = tds[1].querySelector('input').value;
                const precio = tds[2].querySelector('input').value;
                const stock = tds[3].querySelector('input').value;

                fetch(`/productos/${id}`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ nombre, precio, stock })
                })
                .then(res => {
                    if (!res.ok) throw new Error('Error al actualizar producto');
                    return res.json();
                })
                .then(() => {
                    cargarSeccion('productos');
                })
                .catch(error => {
                    alert(error.message);
                });
            }

            if (e.target.classList.contains('btn-cancelar')) {
                cargarSeccion('productos');
            }
        });
        @endif
    </script>

    @stack('scripts')

</body>
</html>