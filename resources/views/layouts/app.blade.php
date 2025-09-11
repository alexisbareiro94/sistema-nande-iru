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
    @include('alertas.alerts')
    <main class="flex-grow grid grid-cols-5 gap-1">
        <div class="col-span-1 bg-gris p-4">
            <aside class=" col-span-1  p-4 fixed">
                @include('home.aside')
            </aside>
        </div>

        <section class="col-span-4 p-6">
            <div class="w-full mx-auto px-4 sm:px-6 lg:px-8 py-6 bg-gray-200 rounded-lg min-h-screen">            
                @yield('contenido')
            </div>
        </section>
        @include('includes.cerrar-sesion')
    </main>

    @yield('js')
    <script src="{{ asset('js/add-producto.js') }}"></script>
    <script src="{{ asset('js/inventario.js') }}"></script>
    <script src="{{ asset('js/edit-producto.js') }}"></script>
    <script src="{{ asset('js/marca.js') }}"></script>
    <script src="{{ asset('js/categoria.js') }}"></script>
    <script src="{{ asset('js/filtros.js') }}"></script>
    @if (request()->routeIs('producto.update.view') || request()->routeIs('producto.update'))
        <script src="{{ asset('js/edit-productorep.js') }}"></script>
    @endif
</body>

</html>
