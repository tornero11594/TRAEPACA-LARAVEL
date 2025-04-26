<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>TraePaCa - Registro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: #0a0a0a;
            overflow: hidden;
            font-family: 'Orbitron', sans-serif;
        }

        .background-layers {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .background-gradient {
            position: absolute;
            width: 200%;
            height: 200%;
            background: radial-gradient(ellipse at center, #1a1a2e 0%, #0a0a0a 70%, #000000 100%);
            animation: animateGradient 60s linear infinite alternate;
            filter: blur(20px) brightness(0.8) saturate(1.2);
        }

        @keyframes animateGradient {
            0% {
                transform: translate(0%, 0%) scale(1);
            }
            100% {
                transform: translate(-25%, -25%) scale(1.2);
            }
        }

        .stars {
            position: absolute;
            width: 100%;
            height: 100%;
        }

        .star {
            position: absolute;
            background: gold;
            border-radius: 50%;
            opacity: 0.7;
            animation: starFloat 15s linear infinite;
        }

        @keyframes starFloat {
            from {
                transform: translateY(100vh) scale(1);
                opacity: 1;
            }
            to {
                transform: translateY(-100vh) scale(0.5);
                opacity: 0;
            }
        }

        .register-box {
            background-color: rgba(0, 0, 0, 0.85);
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 0 25px gold, 0 0 40px #ffcc00, 0 0 60px gold;
            animation: pulseGlow 4s ease-in-out infinite alternate;
        }

        @keyframes pulseGlow {
            0% {
                box-shadow: 0 0 20px #ffcc00, 0 0 40px gold;
            }
            100% {
                box-shadow: 0 0 40px #fff700, 0 0 80px gold, 0 0 100px #ffaa00;
            }
        }

        .btn-super {
            background: linear-gradient(to right, #ffd700, #ff9900);
            color: #000;
            font-weight: bold;
            transition: all 0.3s ease;
            box-shadow: 0 0 15px #ffd700;
        }

        .btn-super:hover {
            transform: scale(1.05);
            box-shadow: 0 0 25px #fff700, 0 0 50px #ffcc00;
        }

        .traepaca-logo {
            background: linear-gradient(to right, #ffcc00, #ff6600);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 2.5rem;
            font-weight: 800;
            text-align: center;
            text-shadow: 0 0 10px #ffcc00;
        }

        .form-label {
            color: #ffcc00;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <video autoplay muted loop playsinline class="fixed top-0 left-0 w-full h-full object-cover z-0 brightness-50">
        <source src="{{ asset('videos/casino2.mp4') }}" type="video/mp4">
        Tu navegador no soporta video HTML5.
    </video>
    

<div class="min-h-screen flex items-center justify-center relative z-10 px-4">
    <div class="register-box w-full max-w-md">

        <div class="mb-8 text-center">
            <div class="traepaca-logo">🎰 TraePaCa</div>
            <p class="text-gray-400 mt-2 text-sm">¡Crea tu cuenta y empieza a pujar!</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-600 text-white px-4 py-2 rounded mb-4 text-center">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf
        
            <div>
                <label class="block mb-1 form-label">Nombre:</label>
                <input type="text" name="nombre"
                       class="w-full p-2 rounded bg-gray-900 border border-yellow-400 text-white focus:outline-none focus:ring-2 focus:ring-yellow-500"
                       required>
            </div>
        
            <div>
                <label class="block mb-1 form-label">Apellidos:</label>
                <input type="text" name="apellidos"
                       class="w-full p-2 rounded bg-gray-900 border border-yellow-400 text-white focus:outline-none focus:ring-2 focus:ring-yellow-500"
                       required>
            </div>
            
            <div>
                <label class="block mb-1 form-label">Edad:</label>
                <input type="number" name="edad"
                       class="w-full p-2 rounded bg-gray-900 border border-yellow-400 text-white focus:outline-none focus:ring-2 focus:ring-yellow-500"
                       required min="1" max="120">
            </div>
        
            <div>
                <label class="block mb-1 form-label">Correo:</label>
                <input type="email" name="correo"
                       class="w-full p-2 rounded bg-gray-900 border border-yellow-400 text-white focus:outline-none focus:ring-2 focus:ring-yellow-500"
                       required>
            </div>
        
            <div>
                <label class="block mb-1 form-label">Contraseña (mínimo 8 caracteres):</label>
                <input type="password" name="contraseña"
                       class="w-full p-2 rounded bg-gray-900 border border-yellow-400 text-white focus:outline-none focus:ring-2 focus:ring-yellow-500"
                       required minlength="8">
            </div>
        
            <div>
                <button type="submit" class="w-full p-2 rounded btn-super">
                    📝 Crear cuenta
                </button>
            </div>
        </form>
        

        <p class="text-center mt-6 text-sm text-yellow-300">
            ¿Ya tienes cuenta? <a href="{{ route('login.form') }}" class="underline hover:text-white">Inicia sesión</a>
        </p>
    </div>
</div>

</body>
</html>
