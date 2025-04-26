
@extends('layouts.app')

@section('content')
    <div class="text-center mt-10 text-white">
        <h1 class="text-3xl font-bold">Pujar por el producto</h1>
        <p>Subasta ID: {{ $subasta->id }}</p>
        <p>Precio actual: {{ $subasta->Precio_actual }} monedas</p>
        <!-- Formulario para pujar aquí -->
    </div>
@endsection
