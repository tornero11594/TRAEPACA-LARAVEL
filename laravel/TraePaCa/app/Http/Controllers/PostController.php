<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    //toda la lógica de nuestra app va dentro de los controladores
    public function index()
    {
        return view('post.index');
    }

    public function create()
    {
        return view('post.create');
    }

    public function store()
    {   
        return "Aquí se procesará el formulario para un post";

    }

    public function show($post)
    {
        return view(view: 'post.show');
    }

    public function edit($post)
    {
        return view(view: 'post.edit');
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
