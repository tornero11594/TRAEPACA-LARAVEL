<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>TraePaCa - Mis Pujas</title>
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
        }

        .logo-text {
            font-size: 2.8rem;
            font-weight: 900;
            letter-spacing: 2px;
            color: white;
            text-transform: uppercase;
            display: flex;
            gap: 0.5rem;
            text-shadow: 0 0 10px #cc66ff, 0 0 20px #9900ff;
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
            font-size: 3rem;
            font-weight: bold;
            text-align: center;
            margin: 2rem 0;
            color: #FFD700;
            text-shadow: 0 0 10px #fff700, 0 0 30px #FF8C00;
        }

        .card {
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: scale(1.03);
            box-shadow: 0 0 20px #FFD700;
        }

        .neon-bg-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: radial-gradient(ellipse at center, #0a0a0a 0%, #000000 100%);
            z-index: 0;
            overflow: hidden;
        }

        canvas {
            display: block;
            width: 100%;
            height: 100%;
        }
    </style>
</head>

<body>
    <div class="neon-bg-container z-0"><canvas id="casinoParticles"></canvas></div>

    <div class="relative z-10">
        <!-- Cabecera -->
        <header class="casino-header">
            <a href="{{ route('paginaprincipal') }}" class="logo-text">🎰 TraePaCa</a>
            <div class="flex items-center ml-auto space-x-4">
                <div class="flex items-center text-black font-bold bg-yellow-300 px-4 py-1 rounded shadow-md">
                    💰 {{ auth()->user()->Monedas ?? 0 }} Monedas
                </div>
                <a href="{{ route('paginaprincipal') }}" class="nav-link">🏠 Volver a Principal</a>
            </div>
        </header>

        <!-- Título -->
        <h1 class="titulo-brillante">🎯 Mis Pujas 🎯</h1>

        <!-- Subastas Creadas -->
        <div class="flex flex-col items-center justify-center px-6 py-10 max-w-7xl mx-auto space-y-12">
            <section class="px-6 py-6">
                <h2 class="text-2xl text-yellow-400 font-bold mb-4">🛠️ Subastas creadas por mí</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($misSubastas as $subasta)
                    <div class="card bg-black bg-opacity-80 border-2 border-yellow-400 rounded-lg p-4">
                        <h3 class="text-xl font-bold text-yellow-300 mb-2">{{ $subasta->producto->Nombre }}</h3>
                        <p class="text-gray-300">{{ $subasta->producto->Descripción }}</p>
                        <p>💰 Precio actual: {{ $subasta->Precio_actual }}</p>
                        <p>📅 Fin: {{ \Carbon\Carbon::parse($subasta->Fecha_fin)->format('d/m/Y') }}</p>
                
                        @if (auth()->user()->getKey() == $subasta->Vendedor || auth()->user()->Administrador)
                            <form action="{{ route('historial.pujas.destroy', ['vendedor' => $subasta->Vendedor, 'producto' => $subasta->Producto]) }}"
                                  method="POST" class="mt-4">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-600 hover:bg-red-500 text-white font-bold py-1 px-3 rounded mt-2">
                                    ❌ Eliminar Subasta
                                </button>
                            </form>
                        @endif
                    </div>
                @empty
                    <p class="text-gray-400">No has creado ninguna subasta.</p>
                @endforelse
                
                </div>
            </section>

            <!-- Subastas en las que participa -->
            <section class="px-6 py-6">
                <h2 class="text-2xl text-yellow-400 font-bold mb-4">🎯 Subastas en las que participo</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($participando as $subasta)
                        <div class="card bg-black bg-opacity-80 border-2 border-yellow-400 rounded-lg p-4">
                            <h3 class="text-xl font-bold text-yellow-300 mb-2">{{ $subasta->producto->Nombre }}</h3>
                            <p class="text-gray-300">{{ $subasta->producto->Descripción }}</p>
                            <p>💰 Precio actual: {{ $subasta->Precio_actual }}</p>
                            <p>📅 Fin: {{ \Carbon\Carbon::parse($subasta->Fecha_fin)->format('d/m/Y') }}</p>
                        </div>
                    @empty
                        <p class="text-gray-400">No participas en ninguna subasta.</p>
                    @endforelse
                </div>
            </section>


            <!-- Formulario de creación -->
            <section class="px-6 py-10">
                <h2 class="text-2xl text-yellow-400 font-bold mb-4">➕ Crear nueva subasta</h2>

                @if ($errors->any())
                    <div class="bg-red-600 text-white p-4 rounded mb-6 shadow-lg">
                        <strong>⚠️ Errores en el formulario:</strong>
                        <ul class="mt-2 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('mispujas.store') }}" method="POST" enctype="multipart/form-data"
                    class="bg-black bg-opacity-80 border-2 border-yellow-500 p-8 rounded-xl shadow-2xl max-w-xl mx-auto space-y-6">
                    @csrf

                    <h3 class="text-2xl font-bold text-yellow-400 text-center mb-4">🪙 Crear Nueva Subasta</h3>

                    <div>
                        <label class="block font-bold text-yellow-300 mb-1">🎁 Nombre del Producto:</label>
                        <input type="text" name="nombre" required
                            class="w-full px-4 py-2 rounded bg-gray-900 text-white border border-yellow-400 focus:outline-none focus:ring-2 focus:ring-yellow-300">
                    </div>

                    <div>
                        <label class="block font-bold text-yellow-300 mb-1">📝 Descripción:</label>
                        <textarea name="descripcion" rows="3" required
                            class="w-full px-4 py-2 rounded bg-gray-900 text-white border border-yellow-400 focus:outline-none focus:ring-2 focus:ring-yellow-300"></textarea>
                    </div>

                    <div>
                        <label class="block font-bold text-yellow-300 mb-1">💰 Precio inicial:</label>
                        <input type="number" name="precio_inicial" min="1" required
                            class="w-full px-4 py-2 rounded bg-gray-900 text-white border border-yellow-400 focus:outline-none focus:ring-2 focus:ring-yellow-300">
                    </div>

                    <div>
                        <label class="block font-bold text-yellow-300 mb-1">📅 Fecha de Fin:</label>
                        <input type="date" name="fecha_fin" required
                            class="w-full px-4 py-2 rounded bg-gray-900 text-white border border-yellow-400 focus:outline-none focus:ring-2 focus:ring-yellow-300">
                    </div>

                    <div>
                        <label class="block font-bold text-yellow-300 mb-1">🖼️ Imagen del Producto:</label>
                        <input type="file" name="imagen" accept="image/*" required
                            class="w-full px-4 py-2 rounded bg-gray-900 text-white border border-yellow-400 focus:outline-none focus:ring-2 focus:ring-yellow-300">
                    </div>

                    <button type="submit"
                        class="w-full bg-yellow-500 hover:bg-yellow-400 text-black font-bold py-2 rounded-lg shadow-lg transition-all duration-300">
                        🚀 Publicar Subasta
                    </button>
                </form>
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                @if (session('success'))

                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: '🎉 ¡Subasta creada!',
                            text: '{{ session('success') }}',
                            confirmButtonColor: '#FFD700',
                            background: '#111',
                            color: '#fff',
                            timer: 3500,
                            timerProgressBar: true,
                            showClass: {
                                popup: 'animate__animated animate__fadeInDown'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__fadeOutUp'
                            }
                        });
                    </script>
                @endif
                @if (session('penalty'))
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <script>
                        Swal.fire({
                            icon: 'warning',
                            title: '⚠️ Penalización',
                            text: '{{ session('penalty') }}',
                            confirmButtonColor: '#FFD700',
                            background: '#111',
                            color: '#fff',
                            timer: 4000,
                            timerProgressBar: true
                        });
                    </script>
                @endif

            </section>

        </div>
    </div>

    <!-- 🎯 Fondo animado -->
    <script>
        const canvas = document.getElementById('casinoParticles');
        const ctx = canvas.getContext('2d');
        canvas.width = window.innerWidth; canvas.height = window.innerHeight;
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
                p.x += p.dx; p.y += p.dy;
                if (p.x < 0 || p.x > canvas.width) p.dx *= -1;
                if (p.y < 0 || p.y > canvas.height) p.dy *= -1;
            });
            requestAnimationFrame(animate);
        }
        animate();
    </script>
</body>

</html>