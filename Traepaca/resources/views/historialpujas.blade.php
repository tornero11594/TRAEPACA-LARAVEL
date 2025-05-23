<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>TraePaCa - Historial de Pujas</title>
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

    <div class="relative z-10">
        <header class="casino-header">
            <a href="{{ route('paginaprincipal') }}" class="logo-text glow-text hover:scale-105 transition">
                🎰 <span class="text-shadow">TraePaCa</span>
            </a>
            <div class="flex items-center ml-auto space-x-4">
                <a href="{{ route('paginaprincipal') }}" class="nav-link">🏠 Volver a Principal</a>
            </div>
        </header>

        <h1 class="titulo-brillante">📜 Historial de Pujas 📜</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 px-6 py-10">
            @foreach ($subastas as $subasta)
                <div class="card bg-black bg-opacity-80 border-2 border-yellow-400 rounded-lg shadow-xl p-4 flex flex-col">
                    <div class="flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0 md:space-x-6">
        
                        {{-- Imagen del producto a la izquierda --}}
                        @if ($subasta->producto->Foto)
                            <img src="data:image/jpeg;base64,{{ base64_encode($subasta->producto->Foto) }}"
                                alt="Imagen del producto" class="w-full md:w-40 h-40 object-contain rounded-lg shadow-md">
                        @endif
        
                        {{-- Info del producto a la derecha --}}
                        <div class="flex-1 text-center md:text-left">
                            <h3 class="text-2xl font-bold text-yellow-400 mb-2">
                                🎯 {{ $subasta->producto->Nombre }}
                            </h3>
                            <p class="text-gray-300 mb-1">{{ $subasta->producto->Descripción }}</p>
                            <p>💰 <strong>Precio actual:</strong> {{ $subasta->Precio_actual }} monedas</p>
                            <p>📅 <strong>Inicio:</strong>
                                {{ \Carbon\Carbon::parse($subasta->Fecha_inicio)->format('d/m/Y') }}</p>
                            <p>⏰ <strong>Fin:</strong> {{ \Carbon\Carbon::parse($subasta->Fecha_fin)->format('d/m/Y') }}</p>
                        </div>
                    </div>
        
                    {{-- Botones centrados abajo --}}
                    <div class="mt-4 flex flex-col items-center space-y-2">
                        @if (\Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($subasta->Fecha_fin)))
                            <div class="bg-red-600 text-white font-bold py-2 px-4 rounded">
                                ⛔ Subasta Finalizada
                            </div>
                        @else
                            <div class="bg-green-500 text-white font-bold py-2 px-4 rounded">
                                ✅ Subasta Activa
                            </div>
                        @endif
        
                        <form
                            action="{{ route('historial.pujas.destroy', ['vendedor' => $subasta->Vendedor, 'producto' => $subasta->Producto]) }}"
                            method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-red-500 hover:bg-red-400 text-white font-bold py-2 px-4 rounded shadow">
                                🗑️ Eliminar Subasta
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="px-6 pb-16">
            <h2 class="text-3xl text-yellow-400 font-bold mt-12 mb-6 text-center">📊 Historial Completo de Subastas</h2>
        
            <div class="overflow-x-auto rounded-lg shadow-xl bg-gradient-to-r from-black via-gray-900 to-black p-6 border border-yellow-400">
                <table class="min-w-full table-auto border-separate border-spacing-y-4 text-sm text-white">
                    <thead class="bg-yellow-500 text-black text-lg uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-3 text-left rounded-l-lg">🧾 Producto</th>
                            <th class="px-6 py-3 text-left">👤 Comprador</th>
                            <th class="px-6 py-3 text-left">💰 Precio</th>
                            <th class="px-6 py-3 text-left">📅 Inicio</th>
                            <th class="px-6 py-3 text-left">⏰ Fin</th>
                            <th class="px-6 py-3 text-left rounded-r-lg">📌 Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subastas as $subasta)
                            <tr class="bg-gray-800 hover:bg-gray-700 transition duration-200 rounded-lg shadow-md">
                                <td class="px-6 py-3 font-semibold text-yellow-300">
                                    {{ $subasta->producto->Nombre }}
                                </td>
                                <td class="px-6 py-3">
                                    @if ($subasta->Comprador)
                                        {{ \App\Models\User::find($subasta->Comprador)?->Nombre ?? 'Desconocido' }}
                                    @else
                                        <span class="text-gray-400 italic">Sin comprador</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3 text-green-300">
                                    {{ $subasta->Precio_actual }} monedas
                                </td>
                                <td class="px-6 py-3">
                                    {{ \Carbon\Carbon::parse($subasta->Fecha_inicio)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-3">
                                    {{ \Carbon\Carbon::parse($subasta->Fecha_fin)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-3">
                                    @if (\Carbon\Carbon::now()->lt(\Carbon\Carbon::parse($subasta->Fecha_fin)))
                                        <span class="bg-green-600 text-white font-bold px-3 py-1 rounded shadow">Activa</span>
                                    @else
                                        <span class="bg-red-600 text-white font-bold px-3 py-1 rounded shadow">Finalizada</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: '¡Acción completada!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#FFD700',
                    background: '#111',
                    color: '#fff'
                });
            </script>
        @endif
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