<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    // Nombre de la tabla
    protected $table = 'usuario';

    // Clave primaria personalizada
    protected $primaryKey = 'id_usuario';

    // Campos que se pueden llenar masivamente
    protected $fillable = [
        'nombre',
        'correo',
        'contrasena',
        'rol',
        'id_carrito',
    ];

    // No utilizar timestamps (created_at, updated_at)
    public $timestamps = false;

    // Desactivar el uso de remember_token
    protected $rememberTokenName = false;

    /**
     * Laravel espera un campo llamado "password", pero como usamos "contrasena",
     * sobrescribimos este método para que lo use correctamente al autenticar.
     */
    public function getAuthPassword()
    {
        return $this->contrasena;
    }
}
