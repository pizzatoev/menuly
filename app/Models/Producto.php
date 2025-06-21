<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Carrito;

class Producto extends Model
{
    use HasFactory;

    // Nombre real de la tabla (en singular)
    protected $table = 'producto';

    // Clave primaria personalizada
    protected $primaryKey = 'id_producto';

    // Desactivamos timestamps (no usas created_at ni updated_at)
    public $timestamps = false;

    // Campos asignables por formularios
    protected $fillable = [
        'nombre',
        'precio',
        'stock',
        'id_carrito',
        'categoria'
    ];

    // Relación opcional con carrito (si usas esta tabla)
    public function carrito()
{
    return $this->belongsTo(Carrito::class, 'id_carrito');

}

}
