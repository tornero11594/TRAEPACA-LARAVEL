<?php

namespace App\Http\Controllers;
use App\Models\Subasta;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Producto;

class MisPujasController extends Controller
{
    public function index()
    {
        $usuario = auth()->user();

        // Subastas creadas por el usuario
        $misSubastas = Subasta::where('Vendedor', $usuario->getKey())->with('producto')->get();

        // Subastas en las que ha pujado (es decir, donde es el Comprador)
        $participando = Subasta::where('Comprador', $usuario->getKey())
            ->where('Vendedor', '!=', $usuario->getKey())
            ->with('producto')
            ->get();

        return view('mispujas', compact('misSubastas', 'participando'));
    }
    public function create()
    {
        return view('mispujas.create');
    }

    public function store(Request $request)
    {
        $usuario = auth()->user();

        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:1000',
            'precio_inicial' => 'required|numeric|min:1',
            'fecha_fin' => 'required|date|after:today',
            'imagen' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Convertir imagen a binario
        $fotoBinario = file_get_contents($request->file('imagen')->getRealPath());

        // Crear producto
        $producto = Producto::create([
            'Nombre' => $request->nombre,
            'Descripción' => $request->descripcion,
            'Foto' => $fotoBinario,
            'Creador' => $usuario->getKey(),
        ]);

        // Crear subasta asociada al producto
        Subasta::create([
            'Vendedor' => $usuario->getKey(),
            'Producto' => $producto->ID_PRODUCTO,
            'Precio_actual' => $request->precio_inicial,
            'Fecha_inicio' => now(),
            'Fecha_fin' => $request->fecha_fin,
            'Comprador' => null,
        ]);
        $usuario->increment('Monedas', 300);


        return redirect()
        ->route('mispujas.index')
        ->with('success', '¡Subasta creada con éxito! Has ganado 300 monedas.');        
    
        
    }


}
