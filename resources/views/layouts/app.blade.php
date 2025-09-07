<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')
    <title>@yield('titulo', 'Mi Aplicación')</title>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6',
                        secondary: '#10B981',
                        danger: '#EF4444',
                        warning: '#F59E0B',
                        info: '#6B7280'
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-[#A4B6B3] min-h-screen flex flex-col">
    <!-- toast alert -->
    <div id="toast-container" class="fixed top-4 right-4 space-y-2 z-[9999]"></div>
    <!-- /toast alert -->
    @include('alertas.alerts')
    <main class="flex-grow grid grid-cols-5 gap-1">        
        <aside class="col-span-1 bg-gris p-4">                        
            @include('home.aside')
        </aside>
        
        <section class="col-span-4 p-6">
            @yield('contenido')
        </section>
        @include('includes.cerrar-sesion')
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
    <script src="{{ asset('js/categoria.js') }}"></script>
    <script src="{{ asset('js/filtros.js') }}"></script>
    @if (request()->routeIs('producto.update.view') || request()->routeIs('producto.update'))
        <script src="{{ asset('js/edit-productorep.js') }}"></script>
    @endif
</body>

</html>
