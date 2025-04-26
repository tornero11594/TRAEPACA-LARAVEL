<!-- resources/views/auth/login.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Iniciar sesión</title>
</head>
<body>
    <h1>Login</h1>
    
    @if ($errors->any())
        <div>
            <strong>¡Error!</strong> {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <label>Correo:</label>
        <input type="email" name="correo" required><br>

        <label>Contraseña:</label>
        <input type="password" name="contraseña" required><br>

        <button type="submit">Iniciar sesión</button>
    </form>
</body>
</html>
