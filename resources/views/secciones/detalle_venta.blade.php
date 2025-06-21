<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h3>Detalle de Venta #{{ $venta->id_venta }}</h3>
                <button class="btn btn-secondary" onclick="cargarSeccion('ventas')">
                    Volver a Ventas
                </button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Información de la Venta</h5>
                    <table class="table table-borderless">
                        <tr>
                            <th>Fecha:</th>
                            <td>{{ $venta->fecha->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Cliente:</th>
                            <td>{{ $venta->cliente->nombre }}</td>
                        </tr>
                        <tr>
                            <th>Tipo de Pedido:</th>
                            <td>{{ $venta->tipo_pedido }}</td>
                        </tr>
                        <tr>
                            <th>Método de Pago:</th>
                            <td>{{ $venta->metodo_pago }}</td>
                        </tr>
                        <tr>
                            <th>Total:</th>
                            <td class="fw-bold">Bs. {{ number_format($venta->total, 2) }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Información del Cliente</h5>
                    <table class="table table-borderless">
                        <tr>
                            <th>CI:</th>
                            <td>{{ $venta->cliente->ci }}</td>
                        </tr>
                        <tr>
                            <th>Nombre:</th>
                            <td>{{ $venta->cliente->nombre }}</td>
                        </tr>
                        <tr>
                            <th>Celular:</th>
                            <td>{{ $venta->cliente->celular }}</td>
                        </tr>
                        <tr>
                            <th>Dirección:</th>
                            <td>{{ $venta->cliente->direccion }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Productos</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="table-danger">
                                <tr>
                                    <th>Producto</th>
                                    <th>Precio Unit.</th>
                                    <th>Cantidad</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($venta->detalles as $detalle)
                                    <tr>
                                        <td>{{ $detalle->producto->nombre }}</td>
                                        <td>Bs. {{ number_format($detalle->producto->precio, 2) }}</td>
                                        <td>{{ $detalle->cantidad }}</td>
                                        <td>Bs. {{ number_format($detalle->subtotal, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Total:</td>
                                    <td class="fw-bold">Bs. {{ number_format($venta->total, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
