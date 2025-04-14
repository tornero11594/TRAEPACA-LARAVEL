<?php
//importamos el controlador
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
//rutas de la app. Es lo que va despues del dominio
//al no indicarle ningún método del controlador toma el que tenga invoke
Route::get(
    '/',
    HomeController::class
    //return view('welcome');
);
//Deberiamos crear tantos controladores como temáticas específicas de la página

//Podemos definir mismas rutas con distintos métodos y dependiendo del entorno se ejecuta uno u otro, es lo mismo que hacer match Son rutas estáticas
/*
Route::get('/contacto',function()
{
    return "Hola desde la página de contactos";


});

Route::post('/contacto',function()
{
    return "Hola desde la página de contactos";


});


//ambas rutas utilizando la URI contacto 
Route::match(['get','post'],'/contacto',function()
{
    return "Hola utilizando match";


});



Route::get('/cursos/informacion',function()
{
    return "Bienvenido aqui encuentras toda la info del curso";

});

//---RUTAS CON CONTENIDO VARIABLE
//vamos a especificar rutas con contenido variable para ello: {curso} es variable
Route::get('/cursos/{curso}',function($curso)
{

    return "Hola Cara nabo, bienvenido al curso ".$curso;
});


//para pasar más de un parámetro:
Route::get('/cursos/{curso}/{category}',function($curso,$category){

    return "Bienvenido al curso".$curso ." de la categoría " .$category;

});


//ruta con parámetro opcional
Route::get('/cursitos/{curso}/{category?}',function($curso,$category=null){

    if($category==null)
        return "Bienvenido al curso sin categoria cara rata";

    else
    return "Bienvenido al curso".$curso ." de la categoría " .$category;

});


//rutas con expresiones regulares, para una mayor seguridad para ello se hace uso de where, en este caso solo se admiten caracteres no numericos. Se le aplica la expresion
//a la variable del parámetro correspondiente
Route::get('/dani/{apellidos}',function($apellidos){
    
    return "Hola Daniel ". $apellidos;

})->where('apellidos','[A-Za-z]+');

//expresiones regulares con más de un parámetro. Para ello se hace uso de un array
Route::get('/dani/{apellidos}/{direccion}',function($apellidos,$direccion){
    
    return "Hola Daniel ". $apellidos . " que vives en ". $direccion;

})->where([
    'apellidos'=>'[A-Za-z]+',
    'direccion'=>'[A-Za-z]+'
]);

//laravel ya tiene expresiones regulares hechas, en este caso los apellidos solo permite letras
Route::get('/tupare/{apellidos}/{direccion}',function($apellidos,$direccion){
    
    return "Hola caranabo ". $apellidos . " que vives en ". $direccion;

})->whereAlpha('apellidos');


//Referencias desde app/providers/appserviceProvider. Cada vez que se pase por parámetro de la url un ID debe ser numérico. Está especificado en esa carpeta
Route::get('/tupare/{id}',function($id){
    
    return "Bienvenido al curso con id: ".$id;
});

*/

//Rutas necesarias para un crud

//Ruta para mostrar el listado de registros. Utilizamos el controlador 
/*

Route::get('/posts',[PostController::class, 'index'])
    ->name('posts.index');

//Ruta para mostrar un formulario para crear un registro
Route::get('/posts/create',[PostController::class, 'create'])
    ->name('posts.create');

//Ruta para guardar un registro
Route::post('/posts',[PostController::class, 'store'])
->name('posts.store');

//Ruta para mostrar un registro
Route::get('/posts/{post}',[PostController::class,'show'])
->name('posts.show');

//Ruta para mostar un registro para actualizarlo
Route::get('/posts/{post}/edit',[PostController::class,'edit'])
->name('posts.edit');

//ruta para actualizar un registro
Route::put('posts/{post}',[PostController::class,'update'])
->name('posts.update');

//Ruta para eliminar un registro
Route::delete('posts/{post}',[PostController::class,'destroy'])
->name('posts.destroy');

*/

//Crear todas las rutas anteriores con una sola linea.  Asigna automáticamete cada URI a su método en específico. Debemos llamar a esos métodos por convención
Route::resource('posts', PostController::class);
//también podemos especificar las rutas que queremos que cree
//Route::resource('posts',PostController::class)
//  ->except('create','edit'); ES EXACTAMENTE LO MISMO QUE usar el método apiresource


//para especificar solo unas rutas en específico:
//Route::resource('posts',PostController::class)
//  ->only('create','edit');


//EN EL CASO DE QUE QUERAMOS CAMBIAR LA URI SIN MODIFICAR TODOS LOS MÉTODOS DEL CONTROLADOR, PODEMOS:
//Route::resource('nombrenuevo',PostController::class)
//  ->names('posts'); //esto llama a los metodos del controlador posts independientemente del nombre
//->parameters(['nombrenuevo' => 'post']); //con esto lo que se hace es que los parámetros de nombrenuevo se llamen post

//Vamos a crear un grupo de rutas que comparten el mismo Controlador. No hace falta por tanto definir el controlador, solo el metodo
/*
Route::prefix('posts')->name('posts.')->controller(PostController::class)->group(function () {

    Route::get('/', 'index')
        ->name('index');

    //Ruta para mostrar un formulario para crear un registro
    Route::get('/create', 'create')
        ->name('create');

    //Ruta para guardar un registro
    Route::post('/', 'store')
        ->name('store');

    //Ruta para mostrar un registro
    Route::get('/{post}', 'show')
        ->name('show');

    //Ruta para mostar un registro para actualizarlo
    Route::get('/{post}/edit', 'edit')
        ->name('edit');

    //ruta para actualizar un registro
    Route::put('/{post}', 'update')
        ->name('update');

    //Ruta para eliminar un registro
    Route::delete('/{post}', 'destroy')
        ->name('destroy');
});

*/