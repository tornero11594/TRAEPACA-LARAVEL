<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subasta extends Model
{
    use HasFactory;

    protected $table = 'Subasta';

    protected $primaryKey = ['Vendedor', 'Producto']; // importante: son dos claves
    public $incrementing = false; // <- muy importante: no hay ID autoincremental
    protected $fillable = [
        'Vendedor',
        'Producto',
        'Precio_actual',
        'Fecha_inicio',
        'Fecha_fin',
        'Comprador',
    ];

    public $timestamps = false;


    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'Producto', 'ID_PRODUCTO');
    }

    public function comprador()
{
    return $this->belongsTo(User::class, 'Comprador', 'id');
}

}