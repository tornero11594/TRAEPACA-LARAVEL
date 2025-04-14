<?php 

namespace App\View\Composers;

use Illuminate\View\View;

    class CompanyComposer
    {
        public function compose(View $view)  {

            $view->with('prueba2', 'Otro mensajillo de prueba hola');

        }


    }



?>