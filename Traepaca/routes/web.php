<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaginaprincipalController;

Route::get('/registro', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/registro', [AuthController::class, 'register'])->name('register');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/paginaprincipal', [PaginaprincipalController::class, 'index'])->name('paginaprincipal');




Route::get('/paginaprincipal', [PaginaprincipalController::class, 'index'])->name('paginaprincipal');

Route::get('/pujar/{vendedor}/{producto}', [PujaController::class, 'show'])->name('pujar');
Route::get('/buscar', [PaginaprincipalController::class, 'buscar'])->name('buscar');


?>