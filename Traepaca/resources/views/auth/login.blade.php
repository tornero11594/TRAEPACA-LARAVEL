<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>TraePaCa - Iniciar sesión</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600&display=swap" rel="stylesheet">

    <style>
        @keyframes blink {
            0% {
                opacity: 0.3;
                transform: scale(0.9);
            }

            100% {
                opacity: 1;
                transform: scale(1.2);
            }
        }

        @keyframes spin-slow {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .animate-spin-slow {
            animation: spin-slow 60s linear infinite;
        }

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
            background: transparent;
            overflow: hidden;
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

        .login-box {
            background-color: rgba(0, 0, 0, 0.65);
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

        .fade-in {
            animation: fadeInZoom 0.8s ease-out;
        }

        @keyframes fadeInZoom {
            from {
                opacity: 0;
                transform: scale(0.8);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .form-label {
            color: #ffcc00;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <video autoplay muted loop playsinline class="fixed top-0 left-0 w-full h-full object-cover z-0 brightness-50">
        <source src="{{ asset('videos/casino.mp4') }}" type="video/mp4">
        Tu navegador no soporta video HTML5.
    </video>
    
    
        

    <!-- 🎰 Login Form -->
    <div class="min-h-screen flex items-center justify-center relative z-10 px-4">
        <div class="login-box w-full max-w-md fade-in">
            <div class="mb-8 text-center">
                <div class="traepaca-logo flex items-center justify-center gap-2">
                    🎰 TraePaCa
                </div>
                <p class="text-gray-400 mt-2 text-sm">¡Donde las pujas brillan como el oro!</p>
            </div>

            @if ($errors->any())
                <div class="bg-red-600 text-white px-4 py-2 rounded mb-4 text-center">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="block mb-1 form-label">Correo:</label>
                    <input type="email" name="correo"
                        class="w-full p-2 rounded bg-gray-900 border border-yellow-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 text-white"
                        required>
                </div>

                <div>
                    <label class="block mb-1 form-label">Contraseña:</label>
                    <input type="password" name="contraseña"
                        class="w-full p-2 rounded bg-gray-900 border border-yellow-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 text-white"
                        required>
                </div>

                <div>
                    <button type="submit" class="w-full p-2 rounded btn-super">
                        🎲 Iniciar sesión
                    </button>
                </div>
            </form>

            <p class="text-center mt-6 text-sm text-yellow-300">
                ¿No tienes cuenta? <a href="registro" class="underline hover:text-white">Regístrate</a>
            </p>
        </div>
    </div>
</body>

</html>