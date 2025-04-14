<?php
//importamos el controlador
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
//rutas de la app. Es lo que va despues del dominio
Route::get('/',[HomeController::class,'index']
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
Route::get('/posts',[PostController::class, 'index'])
    ->name('posts.index');

//Ruta para mostrar un formulario para crear un registro
Route::get('/posts/create',[PostController::class, 'create'])
    ->name('posts.create');

//Ruta para guardar un registro
Route::post('/posts',[PostController::class, 'store'])
->name('posts.store');

//Ruta para mostrar un registro
Route::get('posts/{post}',[PostController::class,'show'])
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