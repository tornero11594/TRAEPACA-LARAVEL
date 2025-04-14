<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Inicio</title>
</head>
<body>
        <h1> Aquí se mostrará el listado de posts </h1>

        <!--Directivas condicionales-->
        @if(false)   
            <p> Este mensaje se mostrará siempre </p> 


        @else
            <p>Esto si se va a mostrar </p>


        @endif


        @unless(false) <!--Similar a if pero para valores falso-->
        
            <p> Le has pasado el valor de false a la directiva de unless </p>

        @endunless



        @isset($posts) <!-- Verifica si la variable se encuentra definida-->
            {{ "La variable prueba está definida" }}
        @endisset



        @empty($variable) <!--Ejecuta el codigo del cuerpo siempre y cuando la variable no exista o no tenga un valor asignado-->
            <p> La variable no existe o no tiene un valor asignado </p>
        @endempty


        <!-- Directivas de environment. Dependiendo del entorno se ejecuta un bloque u otro-->

        @env('local')
            <p> Entorno local </p>
        @endenv

        @env('production')
            <p>Estamos en producción </p>
        @endenv


        <!--Recorrer registros de la bd-->
        <ul>
        @foreach ($posts as $post)
            <li> 
                <h2>
                {{$post['title']}}
                </h2>

                <p>
                    {{$post['content']}}
                
                </p>
            </li>
        @endforeach
        </ul>

        <script>
            let post = @json($posts);
            console.log(post);
            </script>

</body>
</html>