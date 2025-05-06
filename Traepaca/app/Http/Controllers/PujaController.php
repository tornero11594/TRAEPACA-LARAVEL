<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subasta;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

        $usuario = Auth::user();

        if (!$usuario) {
            return redirect()->route('login.form')->with('error', 'Debes iniciar sesión para pujar.');
        }

        if ((int)$usuario->getKey() === $subasta->Vendedor) {
            return redirect()->route('paginaprincipal')
                ->with('error', 'No puedes pujar en tu propia subasta.');
        }

        if ($usuario->Monedas < $request->cantidad) {
            return redirect()->route('paginaprincipal')->with('error', 'No tienes suficientes monedas para realizar esta puja.');
        }

        // Descontar monedas con Eloquent
        $usuario->Monedas -= $request->cantidad;
        $usuario->save();

        // ACTUALIZAR subasta con update() 
        Subasta::where('Vendedor', $vendedor)
            ->where('Producto', $producto)
            ->update([
                'Precio_actual' => $request->cantidad,
                'Comprador' => $usuario->getKey() // ID_USUARIO
            ]);

        return redirect()->route('paginaprincipal')->with('success', '¡Puja realizada con éxito!');
    }




}