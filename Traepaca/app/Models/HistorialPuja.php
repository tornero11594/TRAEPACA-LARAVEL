<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialPuja extends Model
{
    // el nombre real de tu tabla en la base de datos
    protected $table = 'HistorialPujas';
    protected $primaryKey = 'ID';

    // no tienes created_at / updated_at
    public $timestamps = false;

    protected $fillable = [
        'Producto_ID',
        'Usuario_ID',
        'Monto',
        'Fecha',
    ];

    // Metodos para claves foraneas
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'Producto_ID', 'ID_PRODUCTO');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'Usuario_ID', 'id');
    }
}
