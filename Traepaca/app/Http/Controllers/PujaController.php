<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subasta;

class PujaController extends Controller
{
    public function mostrarFormulario($vendedor, $producto)
    {
        $subasta = Subasta::where('Vendedor', $vendedor)
                          ->where('Producto', $producto)
                          ->firstOrFail();
    
        return view('pujas.formulario', compact('subasta'));
    }
    public function realizarPuja(Request $request, $vendedor, $producto)
    {
        $subasta = Subasta::where('Vendedor', $vendedor)
                          ->where('Producto', $producto)
                          ->firstOrFail();

        $request->validate([
            'cantidad' => 'required|numeric|min:' . ($subasta->Precio_actual + 1),
        ]);

        // Actualizar el precio de la subasta
        Subasta::where('Vendedor', $vendedor)
        ->where('Producto', $producto)
        ->update(['Precio_actual' => $request->cantidad]);
 

        return redirect()->route('paginaprincipal')->with('success', '¡Puja realizada con éxito!');
    }
    
}
