<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaccion extends Model
{
    protected $table = 'transacciones';
    
    protected $fillable = [
        'id_carrito',
        'descripcion',
        'monto',
        'fecha'
    ];

    protected $casts = [
        'fecha' => 'date',
        'monto' => 'decimal:2'
    ];

    /**
     * Obtiene el carrito al que pertenece esta transacción
     */
    public function carrito()
    {
        return $this->belongsTo(Carrito::class, 'id_carrito');
    }
} 