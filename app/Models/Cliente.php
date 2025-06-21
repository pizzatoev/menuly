<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'cliente';
    protected $primaryKey = 'ci';
    public $timestamps = false;

    protected $fillable = [
        'ci',
        'nombre',
        'celular',
        'direccion',
        'id_usuario'
    ];

    /**
     * Obtiene las ventas del cliente
     */
    public function ventas()
    {
        return $this->hasMany(Venta::class, 'ci_cliente', 'ci');
    }
} 