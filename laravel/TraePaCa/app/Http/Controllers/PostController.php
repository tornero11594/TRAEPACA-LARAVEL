<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    //toda la lógica de nuestra app va dentro de los controladores
    public function index()
    {
        $posts=[
            [
                'title'=>'Post 1',
                'content' => 'Contenido del Post1'
            ],
            [
                'title'=>'Post 2',
                'content' => 'Contenido del Post2'

            ],
            [
                'title'=>'Post 3',
                'content' => 'Contenido del Post3'
            ]
            ];
        //$etiqueta="<p>Tienes cara de cigala/centollo </p>";
        return view('post.index',['posts' => $posts]);
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
        $prueba="Hola mundo";
        return view('post.show',['post'=> $post, 'prueba' => $prueba]); //el nombre que va entre comillas simples es el que se debe usar en la vista para acceder a dicha variable
        //se podría utilizar también compact('post) que crea un array con la estructura de arriba
    }

    public function edit($post)
    {

        return view('edit.show',['post'=> $post]); //el nombre que va entre comillas simples es el que se debe usar en la vista para acceder a dicha variable
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
