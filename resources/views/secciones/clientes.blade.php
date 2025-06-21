<div class="container-fluid">
    @if(Auth::user()->rol === 'Cajero')
    <div class="row mb-4">
        <div class="col-12">
            <h3>Registro de Clientes</h3>
            <form id="form-cliente" class="card p-3">
                @csrf
                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="ci" class="form-label">CI</label>
                            <input type="text" class="form-control" id="ci" name="ci" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre completo</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="celular" class="form-label">Celular</label>
                            <input type="text" class="form-control" id="celular" name="celular" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Registrar Cliente</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4>Lista de Clientes</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="table-danger">
                                <tr>
                                    <th>CI</th>
                                    <th>Nombre</th>
                                    <th>Celular</th>
                                    <th>Dirección</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($clientes as $cliente)
                                    <tr>
                                        <td>{{ $cliente->ci }}</td>
                                        <td>{{ $cliente->nombre }}</td>
                                        <td>{{ $cliente->celular }}</td>
                                        <td>{{ $cliente->direccion }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-warning btn-editar"
                                                    data-id="{{ $cliente->ci }}">
                                                Editar
                                            </button>
                                            <button class="btn btn-sm btn-danger btn-eliminar"
                                                    data-id="{{ $cliente->ci }}">
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
    // Usar delegación de eventos para manejar el formulario de cliente
    document.addEventListener('submit', function(e) {
        if (e.target && e.target.id === 'form-cliente') {
            e.preventDefault();
            
            const formData = new FormData(e.target);
            
            // Determinar si es una actualización o una creación
            const ci = e.target.dataset.editingId;
            const method = ci ? 'PUT' : 'POST';
            const url = ci ? `/clientes/${ci}` : '/clientes';

            fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    ci: formData.get('ci'),
                    nombre: formData.get('nombre'),
                    celular: formData.get('celular'),
                    direccion: formData.get('direccion')
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const action = ci ? 'actualizado' : 'registrado';
                    alert(`Cliente ${action} correctamente`);
                    e.target.reset();
                    e.target.querySelector('#ci').readOnly = false;
                    e.target.querySelector('button[type="submit"]').textContent = 'Registrar Cliente';
                    delete e.target.dataset.editingId; // Limpiar el estado de edición
                    cargarSeccion('clientes');
                } else {
                    throw new Error(data.message || `Error al ${ci ? 'actualizar' : 'registrar'} el cliente`);
                }
            })
            .catch(error => {
                alert(error.message);
            });
        }
    });

    // Usar delegación para los botones de editar
    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('btn-editar')) {
            const row = e.target.closest('tr');
            const ci = e.target.dataset.id;
            const nombre = row.cells[1].textContent.trim();
            const celular = row.cells[2].textContent.trim();
            const direccion = row.cells[3].textContent.trim();

            const form = document.getElementById('form-cliente');
            if (!form) return;

            // Llenar el formulario con los datos actuales
            form.querySelector('#ci').value = ci;
            form.querySelector('#ci').readOnly = true;
            form.querySelector('#nombre').value = nombre;
            form.querySelector('#celular').value = celular;
            form.querySelector('#direccion').value = direccion;

            // Guardar el ID en el formulario para saber que estamos editando
            form.dataset.editingId = ci;

            // Opcional: Cambiar texto del botón y hacer scroll hacia el formulario
            form.querySelector('button[type="submit"]').textContent = 'Actualizar Cliente';
            form.scrollIntoView({ behavior: 'smooth' });
        }

        if (e.target && e.target.classList.contains('btn-eliminar')) {
            if (!confirm('¿Estás seguro de que deseas eliminar este cliente?')) {
                return;
            }

            const ci = e.target.dataset.id;
            
            fetch(`/clientes/${ci}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Cliente eliminado correctamente');
                    cargarSeccion('clientes');
                } else {
                    throw new Error(data.message || 'Error al eliminar el cliente');
                }
            })
            .catch(error => {
                alert(error.message);
            });
        }
    });
</script> 