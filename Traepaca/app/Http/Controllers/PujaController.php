<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subasta;

class PujaController extends Controller
{
    public function mostrarFormulario($id)
    {
        $subasta = Subasta::findOrFail($id);
        return view('pujas.formulario', compact('subasta'));
    }
}
