<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Subasta;
use Illuminate\Support\Facades\DB;

class PaginaprincipalController extends Controller
{

    public function index()
    {
        $hoy = Carbon::now()->format('Y-m-d');
        $subastas = Subasta::with('producto')
            ->whereDate('Fecha_fin', '>', $hoy)
            ->orderBy('Fecha_fin')
            ->get();

        return view('paginaprincipal', compact('subastas'));
    }
    public function buscar(Request $request)
    {
        $query = $request->input('q');
    
        $subastas = Subasta::whereHas('producto', function($q) use ($query) {
            $q->where('Nombre', 'like', '%' . $query . '%');
        })
        ->where('Fecha_fin', '>=', Carbon::now())  // Solo subastas activas
        ->with('producto') //  Aquí cargamos la relación
        ->get();
    
        return view('paginaprincipal', compact('subastas'));
    }

}


?>