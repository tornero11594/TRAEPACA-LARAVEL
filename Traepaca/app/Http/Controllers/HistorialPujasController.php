<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subasta;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


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
        $subasta = Subasta::where('Vendedor', $vendedor)
            ->where('Producto', $producto)
            ->firstOrFail();
    
        $usuario = auth()->user();
    
        // Si no es ni el admin ni el vendedor real
        if (!$usuario->Administrador && $usuario->getKey() != $subasta->Vendedor) {
            abort(403, 'Acceso no autorizado.');
        }
    
        $ahora = now();
        $fechaFin = Carbon::parse($subasta->Fecha_fin);
    
        // Si la subasta está activa y hay comprador, devolver monedas
        if ($ahora->lt($fechaFin) && $subasta->Comprador) {
            DB::table('Usuarios')
                ->where('id', $subasta->Comprador)
                ->increment('Monedas', $subasta->Precio_actual);
        }
    
        // Penalizar al vendedor si no es administrador
        $penalizacion = false;
        if ($usuario->getKey() == $vendedor && !$usuario->Administrador) {
            DB::table('Usuarios')
                ->where('id', $usuario->getKey())
                ->decrement('Monedas', 300);
            $penalizacion = true;
        }
    
        // Eliminar subasta
        DB::table('Subasta')
            ->where('Vendedor', $vendedor)
            ->where('Producto', $producto)
            ->delete();
    
        // Redirigir según tipo de usuario
        $ruta = $usuario->Administrador ? 'historial.pujas' : 'mispujas.index';
    
        $response = redirect()->route($ruta)->with('success', 'Subasta eliminada correctamente.');
    
        if ($penalizacion) {
            $response->with('penalty', 'Se te han restado 300 monedas por cancelar tu propia subasta.');
        }
    
        return $response;
    }
    
    
}
