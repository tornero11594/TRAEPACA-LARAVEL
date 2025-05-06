<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaginaprincipalController;
use App\Http\Controllers\PujaController;
use App\Http\Controllers\HistorialPujasController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MisPujasController;
use App\Http\Controllers\ProductoController;



Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');


Route::get('/registro', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/registro', [AuthController::class, 'register'])->name('register');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', action: [AuthController::class, 'login'])->name('login');
Route::get('/paginaprincipal', [PaginaprincipalController::class, 'index'])->middleware('auth')->name('paginaprincipal');




//Route::get('/paginaprincipal', action: [PaginaprincipalController::class, 'index'])->name('paginaprincipal');

Route::get('/pujar/{vendedor}/{producto}', [PujaController::class, 'mostrarFormulario'])->name('pujar');
Route::post('/pujar/{vendedor}/{producto}', [PujaController::class, 'realizarPuja'])->name('realizar.puja');
Route::get('/buscar', [PaginaprincipalController::class, 'buscar'])->name('buscar');


Route::middleware(['auth'])->group(function () {
    Route::get('/historial-pujas', [HistorialPujasController::class, 'index'])->name('historial.pujas');
    Route::delete('/historial-pujas/{vendedor}/{producto}', [HistorialPujasController::class, 'destroy'])->name('historial.pujas.destroy');
});

//mis pujas
Route::middleware(['auth'])->group(function () {
    Route::get('/mis-pujas', [MisPujasController::class, 'index'])->name('mispujas.index');
    Route::get('/crear-subasta', [MisPujasController::class, 'crear'])->name('mispujas.crear');
    Route::post('/crear-subasta', [MisPujasController::class, 'store'])->name('mispujas.store');
});


Route::get('/productos-usuarios', [ProductoController::class, 'MostrarProductosUsuarios'])->name('productos.usuarios');

Route::delete('productos-usuarios/{producto}', [ProductoController::class, 'eliminarProducto'])->name('productos.destroy');




?>