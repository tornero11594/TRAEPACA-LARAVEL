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

        $subastas = DB::table('Subasta')
            ->join('Producto', 'Subasta.Producto', '=', 'Producto.ID_PRODUCTO')
            ->select('Subasta.*', 'Producto.Nombre', 'Producto.Descripción', 'Producto.Foto')
            ->where('Producto.Nombre', 'like', '%' . $query . '%')
            ->orderBy('Subasta.Fecha_fin')
            ->get();

        $fechaActual = Carbon::now();

        return view('paginaprincipal', [
            'subastas' => $subastas,
            'fechaActual' => $fechaActual,
            'busqueda' => $query
        ]);
    }

}


?>