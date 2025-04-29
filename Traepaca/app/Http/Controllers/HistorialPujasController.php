<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subasta;
use Illuminate\Support\Facades\Auth;

class HistorialPujasController extends Controller
{
    public function index()
    {
        $usuario = Auth::user();

        if (!$usuario || !$usuario->Administrador) {
            abort(403, 'Acceso no autorizado.');
        }

        $subastas = Subasta::with('producto')
            ->orderBy('Fecha_fin', 'desc')
            ->get();

        return view('historialpujas', compact('subastas'));
    }

    public function destroy($vendedor, $producto)
    {
        Subasta::where('Vendedor', $vendedor)
            ->where('Producto', $producto)
            ->delete();
    
        return redirect()->route('historial.pujas')->with('success', 'Subasta eliminada exitosamente.');
    }
}
