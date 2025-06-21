<h4 class="fw-bold mb-3">Registrar Nuevo Producto</h4>

<form id="form-producto" class="row g-3 mb-4">
    @csrf
    <div class="col-md-4">
        <input type="text" name="nombre" class="form-control" placeholder="Nombre del producto" required>
    </div>
    <div class="col-md-2">
        <input type="number" name="precio" step="0.01" class="form-control" placeholder="Precio (Bs)" required>
    </div>
    <div class="col-md-2">
        <input type="number" name="stock" class="form-control" placeholder="Stock" required>
    </div>
    <div class="col-md-2">
        <select name="categoria" class="form-control" required>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
        </select>
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-success w-100">Registrar</button>
    </div>
</form>

<div id="mensaje"></div>

<hr>

<h4 class="fw-bold mb-3">Lista de Productos</h4>

<table class="table table-bordered table-striped">
    <thead class="table-danger">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Precio (Bs)</th>
            <th>Stock</th>
            <th>Categoría</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($productos as $producto)
            <tr>
                <td>{{ $producto->id_producto }}</td>
                <td>{{ $producto->nombre }}</td>
                <td>{{ number_format($producto->precio, 2) }}</td>
                <td>{{ $producto->stock }}</td>
                <td>{{ $producto->categoria }}</td>
                <td>
                    <button class="btn btn-sm btn-warning btn-editar">Modificar</button>
                    <button class="btn btn-sm btn-danger">Eliminar</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
