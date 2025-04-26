<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'Producto'; // Nombre exacto de la tabla
    protected $primaryKey = 'ID_PRODUCTO'; // Clave primaria personalizada

    public $timestamps = false; // Si no usas created_at y updated_at
}
