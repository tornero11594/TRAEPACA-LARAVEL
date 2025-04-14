<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    //toda la lógica de nuestra app va dentro de los controladores
    public function index()
    {
        return "Hola desde la página de posts";
    }

    public function create()
    {
        return "Aquí se mostrará el formulario para crear un posts";
    }

    public function store()
    {   
        return "Aqui se procesará el formulario para crear un post";
    }

    public function show($post)
    {
        return "Aquí se mostrará el post: " .$post;
    }

    public function edit($post)
    {
        return "Aquí se mostrará el formulario para editar el post ". $post;
    }


    public function update($post)
    {
        return "Aquí se procesará el formulario para editar el post ".$post; 
    }

    public function destroy($post)
    {
        return "Aquí se eliminará un post, en concreto " .$post;
    }
}
