<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Configuración Inicial - Bienvenido</title>
    @vite(['resources/css/app.css'])
</head>

<body class="min-h-screen flex items-center justify-center w-full bg-cover bg-center h-screen backdrop-blur-xs"
    style="background-image: url('{{ asset('images/logo/bg.png') }}');">

    <div class="w-full max-w-md bg-white rounded-xl shadow-md p-6 sm:p-8">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-800">¡Bienvenido!</h1>
            <p class="text-gray-600 mt-2">
                Completa tu perfil para comenzar a usar la plataforma.
            </p>
        </div>

        <form action="{{ route('auth.config') }}" method="POST" class="space-y-5">
            @csrf
            <!-- Nombre completo -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre completo</label>
                <input type="text" id="name" name="name" required autofocus
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                    placeholder="Ej. Juan Pérez">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Correo electrónico -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo electrónico</label>
                <input type="email" id="email" name="email" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                    placeholder="tu@empresa.com">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nueva contraseña -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Nueva contraseña</label>
                <input type="password" id="password" name="password" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                    placeholder="••••••••">
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <input type="checkbox" name="show_pass" id="show_pass">
                <label for="show_pass">Mostrar Contraseña</label>
            </div>
            <!-- Nombre de la empresa (opcional) -->
            <div>
                <label for="empresa" class="block text-sm font-medium text-gray-700 mb-1">Nombre de la empresa <span
                        class="text-gray-500">(opcional)</span></label>
                <input type="text" id="empresa" name="empresa"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                    placeholder="Ej. Empresa S.A.">
                @error('empresa')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Botón de enviar -->
            <div class="pt-4">
                <button type="submit"
                    class="cursor-pointer w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 px-4 rounded-lg transition duration-200 shadow-sm">
                    Guardar y continuar
                </button>
            </div>

        </form>
        <form action="{{ route('config.omitido') }}" method="POST">
            @csrf
            <div class="pt-2">
                <button id="omitir" type="submit"
                    class="cursor-pointer w-full font-semibold border border-white hover:border-gray-700 text-gray-700 py-2.5 px-4 rounded-lg transition duration-200">
                    Omitir
                </button>
            </div>
        </form>

    </div>

    <script type="module">
        const $ = el => document.querySelector(el);
        const $el = (el, event, callback) => {
            return document.querySelector(el).addEventListener(event, callback)
        }

        $el('#show_pass', 'change', e => {
            const input = $('#password')
            console.log('message')
            if (input.type == 'password') {
                input.type = 'text'
            } else {
                input.type = 'password'
            }
        });
    </script>
</body>

</html>
