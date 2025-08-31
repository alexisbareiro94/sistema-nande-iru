<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')
    <title>@yield('titulo', 'Mi Aplicación')</title>
</head>

<body class="bg-[#A4B6B3] min-h-screen flex flex-col">
<div id="toast-container" class="fixed top-4 right-4 space-y-2 z-[9999]"></div>
    <header class="bg-[#FFC60A] text-black shadow-md">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <a href="{{ url('/') }}" class="text-xl font-bold">MiApp</a>

            <nav class="space-x-4 flex">
                <a href="" class="hover:text-[#CC0000] font-semibold">Inicio</a>
                <a href="" class="hover:text-[#CC0000] font-semibold">Perfil</a>
                <span id="cerrar-sesion" class="hover:text-[#CC0000] font-semibold cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                    </svg>
                </span>
            </nav>
        </div>
    </header>
    <main class="flex-grow ">
        @yield('contenido')
        @include('includes.cerrar-sesion')
        @include('alertas.alerts')
    </main>
    <footer class="bg-[#000000] text-white py-4">
        <div class="max-w-7xl mx-auto px-4 text-center text-sm">
            &copy; {{ date('Y') }} MiApp. Todos los derechos reservados.
        </div>
    </footer>

    @yield('js')
    <script src="{{ asset('js/add-producto.js') }}"></script>
    <script src="{{ asset('js/inventario.js') }}"></script>
    <script src="{{ asset('js/edit-producto.js') }}"></script>
    <script src="{{ asset('js/marca.js') }}"></script>
    <script src="{{ asset('js/categoria.js')  }}"></script>
    <script src="{{ asset('js/filtros.js') }}"></script>
    @if (request()->routeIs('producto.update.view') || request()->routeIs('producto.update'))
        <script src="{{ asset('js/edit-productorep.js') }}"></script>
    @endif
</body>
</html>
