<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>TraePaCa - Productos de Usuarios</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Orbitron', sans-serif;
            background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 100%);
            color: white;
            overflow-x: hidden;
        }

        .casino-header {
            background: linear-gradient(to right, #FFD700, #FF8C00);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 0 15px #FFA500;
            position: relative;
            z-index: 10;
        }

        .logo-text {
            font-size: 2.8rem;
            font-weight: 900;
            letter-spacing: 2px;
            color: white;
            text-shadow:
                0 0 5px #cc66ff,
                0 0 10px #9900ff,
                0 0 15px #cc66ff,
                0 0 20px #cc66ff;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-link {
            color: black;
            font-weight: bold;
            margin-left: 1.5rem;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: white;
            transform: scale(1.1);
        }

        .titulo-brillante {
            font-size: 3.5rem;
            font-weight: bold;
            text-align: center;
            margin-top: 2rem;
            color: #FFD700;
            text-shadow: 0 0 10px #fff700, 0 0 30px #FF8C00;
            animation: pulse 2s infinite alternate;
        }

        @keyframes pulse {
            0% {
                text-shadow: 0 0 10px #FFD700;
            }

            100% {
                text-shadow: 0 0 30px #FF8C00;
            }
        }

        .neon-bg-container {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 0;
            width: 100vw;
            height: 100vh;
            overflow: hidden;
            background: radial-gradient(ellipse at center, #0a0a0a 0%, #000000 100%);
        }

        canvas {
            display: block;
            width: 100%;
            height: 100%;
        }
    </style>
</head>

<body>
    <div class="neon-bg-container z-0">
        <canvas id="casinoParticles"></canvas>
    </div>

    <div class="relative z-10">
        <header class="casino-header">
            <a href="{{ route('paginaprincipal') }}" class="logo-text hover:scale-105 transition">
                🎰 <span class="text-shadow">TraePaCa</span>
            </a>

            <nav>
                <a href="#" class="nav-link">Mis Pujas</a>
                @if (auth()->check() && auth()->user()->Administrador == 1)
                    <a href="#" class="nav-link">Historial de Pujas</a>
                    <a href="{{ route('productos.usuarios') }}" class="nav-link">Productos de todos los Usuarios</a>
                @endif
            </nav>
        </header>

        <h1 class="titulo-brillante">📦 Productos de Usuarios 📦</h1>

        <!-- Mensaje que aparece si se ha eliminado un producto -->
        @if(session('status'))
            <div class="mb-4 bg-green-600 text-white px-4 py-2 rounded">
            {{ session('status') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8 px-6 py-10">
            @foreach ($productos as $producto)
                <div class="bg-black bg-opacity-90 border-2 border-yellow-400 rounded-xl shadow-xl p-6 flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0 md:space-x-6 transition-transform transform hover:scale-105">
                    <!-- Imagen -->
                    <div class="flex-shrink-0 w-full md:w-1/2">
                        <img src="data:image/jpeg;base64,{{ base64_encode($producto->Foto) }}"
                            alt="Imagen del producto"
                            class="w-full h-auto max-h-64 object-contain rounded shadow-lg border border-yellow-500">
                    </div>

                    <!-- Detalles -->
                    <div class="flex flex-col justify-between w-full md:w-1/2 text-white space-y-3 text-sm">
                        <h2 class="text-2xl text-yellow-400 font-bold flex items-center gap-2">
                            🎯 {{ $producto->Nombre }}
                        </h2>
                        <p class="text-gray-300">{{ $producto->Descripción }}</p>
                        <div class="space-y-1 text-white mt-2">
                            <p>👤 <strong class="text-yellow-400">Creador:</strong> {{ $producto->creadorUsuario?->Nombre ?? 'Desconocido' }}</p>
                            {{-- Agrega más info aquí si lo deseas --}}
                        </div>
                    </div>
                    <!-- Boton eliminar producto -->
                    <form 
                        method="POST"
                        action="{{ url('productos-usuarios/'.$producto->ID_PRODUCTO) }}"
                        onsubmit="return confirm('¿Seguro que quieres eliminar este producto?');"
                        >
                        @csrf <!-- Crea el token de sesion para que no accedan terceros -->
                        @method('DELETE') <!-- Permite definir una ruta que es un delete -->
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        Eliminar producto
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        const canvas = document.getElementById('casinoParticles');
        const ctx = canvas.getContext('2d');

        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;

        window.addEventListener('resize', () => {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        });

        const particles = [];

        for (let i = 0; i < 100; i++) {
            particles.push({
                x: Math.random() * canvas.width,
                y: Math.random() * canvas.height,
                radius: Math.random() * 2 + 1,
                dx: (Math.random() - 0.5) * 0.5,
                dy: (Math.random() - 0.5) * 0.5,
                color: ['#FFD700', '#FF66CC', '#00FFFF'][Math.floor(Math.random() * 3)]
            });
        }

        function animate() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            particles.forEach(p => {
                ctx.beginPath();
                ctx.arc(p.x, p.y, p.radius, 0, Math.PI * 2);
                ctx.fillStyle = p.color;
                ctx.shadowColor = p.color;
                ctx.shadowBlur = 10;
                ctx.fill();
                p.x += p.dx;
                p.y += p.dy;

                if (p.x < 0 || p.x > canvas.width) p.dx *= -1;
                if (p.y < 0 || p.y > canvas.height) p.dy *= -1;
            });
            requestAnimationFrame(animate);
        }

        animate();
    </script>
</body>
</html>