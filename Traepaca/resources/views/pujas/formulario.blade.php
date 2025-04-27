<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Pujar por el Producto - TraePaCa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Orbitron', sans-serif;
            background: radial-gradient(ellipse at center, #0a0a0a 0%, #000000 100%);
            color: white;
            overflow-x: hidden;
        }

        .neon-bg-container {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 0;
            width: 100vw;
            height: 100vh;
            overflow: hidden;
        }

        canvas {
            display: block;
            width: 100%;
            height: 100%;
        }

        .card {
            background-color: rgba(0, 0, 0, 0.7);
            border: 2px solid #FFD700;
            border-radius: 1rem;
            box-shadow: 0 0 20px #FFD700;
            padding: 2rem;
            max-width: 900px;
            margin: auto;
        }

        .btn-pujar {
            background: linear-gradient(to right, #FFD700, #FF8C00);
            color: black;
            font-weight: bold;
            transition: all 0.3s ease;
            box-shadow: 0 0 10px #FFD700;
        }

        .btn-pujar:hover {
            transform: scale(1.05);
            box-shadow: 0 0 20px #FF8C00;
        }

        .titulo-brillante {
            font-size: 3rem;
            font-weight: bold;
            text-align: center;
            margin-top: 2rem;
            margin-bottom: 2rem;
            color: #FFD700;
            text-shadow: 0 0 10px #fff700, 0 0 30px #FF8C00;
            animation: pulse 2s infinite alternate;
        }

        @keyframes pulse {
            0% { text-shadow: 0 0 10px #FFD700; }
            100% { text-shadow: 0 0 30px #FF8C00; }
        }
    </style>
</head>

<body>

    <!-- ✨ Fondo animado -->
    <div class="neon-bg-container z-0">
        <canvas id="casinoParticles"></canvas>
    </div>

    <div class="relative z-10">
        <h1 class="titulo-brillante">🎰 Pujar por el Producto 🎰</h1>

        <div class="card grid grid-cols-1 md:grid-cols-2 gap-8">
            @if ($subasta->producto->Foto)
                <img src="data:image/jpeg;base64,{{ base64_encode($subasta->producto->Foto) }}" 
                    alt="Imagen del producto"
                    class="w-full max-h-80 object-contain rounded-lg shadow-md">
            @endif

            <div class="flex flex-col justify-center">
                <h2 class="text-2xl font-bold text-yellow-400 mb-2">{{ $subasta->producto->Nombre }}</h2>
                <p class="text-gray-300 mb-4">{{ $subasta->producto->Descripción }}</p>

                <p class="text-white mb-2"><strong>💰 Precio actual:</strong> {{ $subasta->Precio_actual }} monedas</p>

                <form action="{{ route('realizar.puja', ['vendedor' => $subasta->Vendedor, 'producto' => $subasta->Producto]) }}" method="POST" class="space-y-4 mt-4">
                    @csrf
                    <div>
                        <label for="cantidad" class="block mb-2 text-yellow-300 font-semibold">Cantidad a pujar:</label>
                        <input type="number" name="cantidad" id="cantidad" min="{{ $subasta->Precio_actual + 1 }}"
                            class="w-full p-2 rounded bg-gray-800 border border-yellow-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 text-white" required>
                    </div>

                    <button type="submit"
                        class="btn-pujar w-full py-2 rounded shadow-lg transition">
                        💸 Realizar Puja
                    </button>
                </form>

                <a href="{{ route('paginaprincipal') }}" class="mt-6 inline-block text-yellow-400 hover:text-white transition text-center">
                    ⬅️ Volver a subastas
                </a>
            </div>
        </div>
    </div>

    <!-- 🎯 Fondo animado -->
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
