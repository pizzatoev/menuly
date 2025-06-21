<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Ventas</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --danger-color: #dc3545;
            --danger-hover: #bb2d3b;
            --success-color: #198754;
            --primary-color: #0d6efd;
            --light-bg: #f8f9fa;
        }

        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
        }

        .card {
            border: none;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border-radius: 15px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.12);
        }

        .form-select, .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
            padding: 12px 16px;
        }

        .form-select:focus, .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
            transform: translateY(-1px);
        }

        .btn {
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .table-danger {
            background: linear-gradient(135deg, var(--danger-color), var(--danger-hover));
            color: white;
        }

        .table-danger th {
            border: none;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .table {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .table tbody tr {
            transition: all 0.2s ease;
        }

        .table tbody tr:hover {
            background-color: rgba(13, 110, 253, 0.05);
            transform: scale(1.01);
        }

        .modal-content {
            border-radius: 20px;
            border: none;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary-color), #0b5ed7);
            color: white;
            border-radius: 20px 20px 0 0;
            border: none;
            padding: 20px;
        }

        .modal-title {
            font-weight: 600;
        }

        .section-title {
            color: var(--danger-color);
            font-weight: 700;
            margin-bottom: 30px;
            position: relative;
            padding-bottom: 10px;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: linear-gradient(90deg, var(--danger-color), var(--danger-hover));
            border-radius: 2px;
        }

        .product-section {
            background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
            border-radius: 15px;
            padding: 25px;
            margin: 20px 0;
            border: 2px solid rgba(220, 53, 69, 0.1);
        }

        .total-section {
            background: linear-gradient(135deg, var(--success-color), #157347);
            color: white;
            padding: 15px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
        }

        .badge-custom {
            background: linear-gradient(135deg, var(--danger-color), var(--danger-hover));
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .stats-card {
            background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
            border-left: 4px solid var(--danger-color);
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .floating-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--success-color), #157347);
            color: white;
            border: none;
            font-size: 24px;
            box-shadow: 0 4px 20px rgba(25, 135, 84, 0.4);
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .floating-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 25px rgba(25, 135, 84, 0.6);
        }

        .form-section {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            border-top: 4px solid var(--danger-color);
        }

        @media (max-width: 768px) {
            .action-buttons {
                justify-content: center;
            }
            
            .floating-btn {
                bottom: 20px;
                right: 20px;
                width: 50px;
                height: 50px;
                font-size: 20px;
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
        <div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h3>Registro de Venta</h3>
            <form id="form-venta" class="card p-3">
                @csrf
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="ci_cliente" class="form-label">Cliente</label>
                        <select class="form-select" id="ci_cliente" name="ci_cliente" required>
                            <option value="">Seleccione un cliente</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->ci }}">
                                    {{ $cliente->nombre }} - {{ $cliente->ci }}
                                </option>
                            @endforeach
                        </select>
                        @if(Auth::user()->rol === 'Cajero')
                            <div class="mt-2">
                                <button type="button" class="btn btn-sm btn-success" 
                                        onclick="cargarSeccion('clientes')">
                                    Registrar Nuevo Cliente
                                </button>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-4">
                        <label for="tipo_pedido" class="form-label">Tipo de Pedido</label>
                        <select class="form-select" id="tipo_pedido" name="tipo_pedido" required>
                            <option value="Para llevar">Para llevar</option>
                            <option value="Delivery">Delivery</option>
                            <option value="Consumo en sitio">Consumo en sitio</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="metodo_pago" class="form-label">Método de Pago</label>
                        <select class="form-select" id="metodo_pago" name="metodo_pago" required>
                            <option value="Efectivo">Efectivo</option>
                            <option value="QR">QR</option>
                            <option value="Tarjeta">Tarjeta</option>
                        </select>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <h5>Productos</h5>
                        <div class="table-responsive">
                            <table class="table" id="tabla-productos">
                                <thead class="table-danger">
                                    <tr>
                                        <th>Producto</th>
                                        <th>Precio</th>
                                        <th>Cantidad</th>
                                        <th>Subtotal</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold">Total:</td>
                                        <td class="fw-bold" id="total">Bs. 0.00</td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="mt-3">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarProductoModal">
                                Agregar Producto
                            </button>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <button type="submit" class="btn btn-success">Registrar Venta</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4>Historial de Ventas</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="table-danger">
                                <tr>
                                    <th>ID</th>
                                    <th>Fecha</th>
                                    <th>Cliente</th>
                                    <th>Tipo</th>
                                    <th>Método Pago</th>
                                    <th>Total</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ventas as $venta)
                                    <tr>
                                        <td>{{ $venta->id_venta }}</td>
                                        <td>{{ $venta->fecha->format('d/m/Y H:i') }}</td>
                                        <td>{{ $venta->cliente->nombre }}</td>
                                        <td>{{ $venta->tipo_pedido }}</td>
                                        <td>{{ $venta->metodo_pago }}</td>
                                        <td>Bs. {{ number_format($venta->total, 2) }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-info" 
                                                    onclick="cargarSeccion('detalle_venta', {{ $venta->id_venta }})">
                                                Ver Detalle
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Agregar Producto -->
<div class="modal fade" id="agregarProductoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="producto" class="form-label">Producto</label>
                    <select class="form-select" id="producto">
                        <option value="">Seleccione un producto</option>
                        @foreach($productos as $producto)
                            <option value="{{ $producto->id_producto }}" 
                                    data-precio="{{ $producto->precio }}"
                                    data-stock="{{ $producto->stock }}">
                                {{ $producto->nombre }} - Bs. {{ number_format($producto->precio, 2) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="cantidad" class="form-label">Cantidad</label>
                    <input type="number" class="form-control" id="cantidad" min="1" value="1">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="agregarProducto()">Agregar</button>
            </div>
        </div>
    </div>
</div>
</body>


<script>
    let productosVenta = [];

    function actualizarTabla() {
        const tbody = document.querySelector('#tabla-productos tbody');
        tbody.innerHTML = '';
        let total = 0;

        productosVenta.forEach((item, index) => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${item.nombre}</td>
                <td>Bs. ${item.precio.toFixed(2)}</td>
                <td>${item.cantidad}</td>
                <td>Bs. ${(item.precio * item.cantidad).toFixed(2)}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger" onclick="eliminarProducto(${index})">
                        Eliminar
                    </button>
                </td>
            `;
            tbody.appendChild(tr);
            total += item.precio * item.cantidad;
        });

        document.getElementById('total').textContent = `Bs. ${total.toFixed(2)}`;
    }

    function agregarProducto() {
        const select = document.getElementById('producto');
        const cantidad = parseInt(document.getElementById('cantidad').value);
        
        if (!select.value || cantidad < 1) {
            alert('Por favor seleccione un producto y una cantidad válida');
            return;
        }

        const option = select.selectedOptions[0];
        const stock = parseInt(option.dataset.stock);

        if (cantidad > stock) {
            alert(`Solo hay ${stock} unidades disponibles`);
            return;
        }

        productosVenta.push({
            id_producto: select.value,
            nombre: option.text,
            precio: parseFloat(option.dataset.precio),
            cantidad: cantidad
        });

        actualizarTabla();
        var modal = bootstrap.Modal.getInstance(document.getElementById('agregarProductoModal'));
        if (modal) {
            modal.hide();
        }
    }

    function eliminarProducto(index) {
        productosVenta.splice(index, 1);
        actualizarTabla();
    }

    // Usar delegación de eventos para el formulario
    document.addEventListener('submit', function(e) {
        if (e.target && e.target.id === 'form-venta') {
            e.preventDefault();
            
            if (productosVenta.length === 0) {
                alert('Debe agregar al menos un producto');
                return;
            }

            const formData = new FormData(e.target);
            
            fetch('/ventas', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    ci_cliente: formData.get('ci_cliente'),
                    tipo_pedido: formData.get('tipo_pedido'),
                    metodo_pago: formData.get('metodo_pago'),
                    productos: productosVenta.map(item => ({
                        id_producto: item.id_producto,
                        cantidad: item.cantidad
                    }))
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Venta registrada correctamente');
                    e.target.reset();
                    productosVenta = [];
                    actualizarTabla();
                    cargarSeccion('ventas');
                } else {
                    throw new Error(data.message || 'Error al registrar la venta');
                }
            })
            .catch(error => {
                alert(error.message);
            });
        }
    });
</script>
