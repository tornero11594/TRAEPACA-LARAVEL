<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subasta extends Model
{
    use HasFactory;

    protected $table = 'Subasta';

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


}
