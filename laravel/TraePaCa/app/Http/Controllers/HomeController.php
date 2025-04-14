<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return "Holaa desde la página de inicio";
    }

    //metodo invocable
    public function __invoke()
    {
        return view('welcome');
    }

}
