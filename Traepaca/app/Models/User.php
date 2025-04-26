<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'Usuarios';

    protected $fillable = [
        'Nombre',
        'Apellidos',
        'Edad',
        'Correo',
        'Contraseña',
        'Monedas',
        'Administrador',
    ];

    public $timestamps = false;

    protected $hidden = [
        'Contraseña',
    ];

    protected $guarded = ['password'];

    public function getAuthIdentifierName()
    {
        return 'Correo';
    }

    public function getAuthPassword()
    {
        return $this->Contraseña;
    }

    // 👇 Esto evita que Laravel intente guardar en "password"
    public function setPasswordAttribute($value)
    {
        // Nada: prevenimos escritura accidental
    }
}
