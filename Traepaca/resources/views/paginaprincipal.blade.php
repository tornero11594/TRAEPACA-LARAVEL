<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>TraePaCa - Subastas</title>
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

        .card {
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: scale(1.03);
            box-shadow: 0 0 20px #FFD700;
        }

        .btn-pujar {
            transition: all 0.3s ease;
            animation: glow 2s infinite ease-in-out;
        }

        .btn-pujar:hover {
            transform: scale(1.05);
        }

        @keyframes glow {
            0% {
                box-shadow: 0 0 5px #FFD700;
            }

            100% {
                box-shadow: 0 0 20px #FF8C00;
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
    <!-- 🎰 Fondo animado -->
    <div class="neon-bg-container z-0">
        <canvas id="casinoParticles"></canvas>
    </div>

    <!-- 🎯 Contenido principal -->
    <div class="relative z-10">
        <header class="casino-header">
            <div class="logo-text glow-text">
                🎰 <span class="text-shadow">TraePaCa</span>
            </div>
            <form action="{{ route('buscar') }}" method="GET" class="flex items-center ml-auto">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="🔍 Buscar producto..."
                    class="rounded-l px-3 py-1 border-none focus:outline-none text-black" />
                <button type="submit" class="bg-yellow-400 px-3 py-1 rounded-r text-black font-bold hover:bg-yellow-300">
                    Buscar
                </button>
            </form>
            
            <nav>
                <a href="#" class="nav-link">Mis Pujas</a>
                @if (auth()->check() && auth()->user()->Administrador)
                    <a href="#" class="nav-link">Historial de Pujas</a>
                    <a href="#" class="nav-link">Productos de todos los Usuarios</a>
                @endif
            </nav>
            
        </header>

        <h1 class="titulo-brillante">🎲 Productos en Subastas 🎲</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 px-6 py-10">
            @foreach ($subastas as $subasta)
                <div class="card bg-black bg-opacity-80 border-2 border-yellow-400 rounded-lg shadow-xl p-4">
                    <h3 class="text-xl font-bold text-yellow-400 flex items-center gap-2 mb-2">
                        🎯 {{ $subasta->producto->Nombre }}
                    </h3>
                    <p class="text-gray-200 mb-2">{{ $subasta->producto->Descripción }}</p>

                    @if ($subasta->producto->Foto)
                        <img src="data:image/jpeg;base64,{{ base64_encode($subasta->producto->Foto) }}" alt="Imagen del producto"
                            class="w-full h-48 object-cover rounded-lg mb-4">
                    @endif

                    <p class="text-white">💰 <strong>Precio actual:</strong> {{ $subasta->Precio_actual }} monedas</p>
                    <p class="text-white">📅 <strong>Activa desde:</strong>
                        {{ \Carbon\Carbon::parse($subasta->Fecha_inicio)->format('d/m/Y') }}</p>
                    <p class="text-white">⏰ <strong>Finaliza:</strong>
                        {{ \Carbon\Carbon::parse($subasta->Fecha_fin)->format('d/m/Y') }}</p>

                    <a href="{{ route('pujar', ['vendedor' => $subasta->Vendedor, 'producto' => $subasta->Producto]) }}"
                        class="btn-pujar mt-4 inline-block bg-yellow-500 hover:bg-yellow-400 text-black font-bold py-2 px-4 rounded shadow-lg transition">
                        🎰 Pujar
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <!-- 🎯 Animación fondo -->
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
