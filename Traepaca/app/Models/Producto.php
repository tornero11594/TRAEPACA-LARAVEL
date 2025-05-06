<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{

    protected $table = 'Producto'; // Nombre exacto de la tabla
    protected $primaryKey = 'ID_PRODUCTO'; // Clave primaria personalizada

    protected $fillable = [
        'Nombre',
        'Descripción',
        'Foto',
        'Creador',
    ];

    public $incrementing = true;
    public $timestamps = false;
    public function creadorUsuario()
    {
        return $this->belongsTo(User::class, 'Creador', 'id');
    }
     // Metodos para claves foraneas
     public function pujas()
     {
         return $this->hasMany(HistorialPuja::class, 'Producto_ID', 'ID_PRODUCTO');
     }
     public function subastas()
     {
         return $this->hasMany(Subasta::class, 'Producto', 'ID_PRODUCTO');
     }
}
