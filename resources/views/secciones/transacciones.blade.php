<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h3>Registro de Transacciones</h3>
            <form id="form-transaccion" class="card p-3">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <input type="text" class="form-control" id="descripcion" name="descripcion" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="monto" class="form-label">Monto (Bs)</label>
                            <input type="number" class="form-control" id="monto" name="monto" step="0.01" min="0" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="fecha" class="form-label">Fecha</label>
                            <input type="date" class="form-control" id="fecha" name="fecha" required 
                                   value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Registrar Transacción</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4>Historial de Transacciones</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Descripción</th>
                                    <th>Monto</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transacciones as $transaccion)
                                    <tr>
                                        <td>{{ $transaccion->fecha->format('d/m/Y') }}</td>
                                        <td>{{ $transaccion->descripcion }}</td>
                                        <td>Bs {{ number_format($transaccion->monto, 2) }}</td>
                                        <td>
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger eliminar-transaccion"
                                                    data-id="{{ $transaccion->id_gasto }}">
                                                Eliminar
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

<script>
    // Usar delegación para el formulario de transacción
    document.addEventListener('submit', function(e) {
        if (e.target && e.target.id === 'form-transaccion') {
            e.preventDefault();
            
            const formData = new FormData(e.target);
            
            // Reemplazar coma por punto en el monto
            if (formData.get('monto')) {
                formData.set('monto', formData.get('monto').replace(',', '.'));
            }
            
            fetch('/transacciones', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Transacción registrada correctamente');
                    e.target.reset();
                    cargarSeccion('transacciones');
                } else {
                    throw new Error(data.message || 'Error al registrar la transacción');
                }
            })
            .catch(error => {
                alert(error.message);
            });
        }
    });

    // Usar delegación para eliminar transacción
    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('eliminar-transaccion')) {
            if (!confirm('¿Está seguro de eliminar esta transacción?')) return;

            const id = e.target.dataset.id;
            
            fetch(`/transacciones/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    cargarSeccion('transacciones');
                } else {
                    throw new Error(data.message || 'Error al eliminar la transacción');
                }
            })
            .catch(error => {
                alert(error.message);
            });
        }
    });
</script> 