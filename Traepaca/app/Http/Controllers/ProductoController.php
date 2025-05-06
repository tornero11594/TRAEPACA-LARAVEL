<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class ProductoController extends Controller
{
    public function MostrarProductosUsuarios()
    {
        $productos = Producto::with('creadorUsuario')->get();
        return view('productos_usuarios', compact('productos'));
    }

    public function eliminarProducto(Producto $producto)
    {
        DB::transaction(function() use ($producto) 
        {
            // 1) Reembolsar según Precio_actual de cada subasta
            $producto->subastas()
                     ->with('comprador')           // cargamos la relación comprador()
                     ->get()
                     ->each(function($subasta) 
                     {
                         $user = $subasta->comprador;
                        
                         $user->Monedas += $subasta->Precio_actual;
                         $user->save();
                     });
    
            // 2) Borrar primero las pujas relacionadas
            $producto->pujas()->delete();
    
            // 3) Borrar las subastas relacionadas
            $producto->subastas()->delete();
    
            // 4) Finalmente borrar el producto
            $producto->delete();
        });
    
        return redirect()
            ->route('productos.usuarios')
            ->with('status', 'Producto eliminado y monedas reembolsadas según precio actual de subasta.');
    }
}
