<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        window.userId = {{ auth()->id() }};
        window.tenantId = {{ auth()->user()->tenant_id }}
    </script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>@yield('titulo', 'Mi Aplicación')</title>
</head>

<body class="bg-gris min-h-screen flex flex-col">    
    <div id="pdf-notificacion" class="fixed top-4 right-4 space-y-2 z-[9999]"></div>
    <div id="toast-container" class="fixed top-4 right-4 space-y-2 z-[9999]"></div>
    <div id="loading-container" class="fixed top-4 right-4 space-y-2 z-[9999]"></div>
    <div id="notificaciones" class="fixed top-4 right-4 space-y-2 z-[9999]"></div>
    @include('alertas.alerts')
    <main class="flex-grow grid grid-cols-5 gap-1">
        <div @class([
            'bg-gris p-4 animate-fade-in',
            'hidden' => request()->routeIs('home') || auth()->user()->role != 'admin',
            'col-span-1 animate-slide-in-right' => !request()->routeIs('home'),
        ])>
            <aside class="col-span-1 p-4 fixed transform transition-transform duration-300">
                @include('home.aside')
            </aside>
        </div>
        <section @class([
            'p-6',            
            'col-span-5' => request()->routeIs('home') || auth()->user()->role != 'admin',
            'col-span-4' => !request()->routeIs('home'),            
        ])>
            <div class="w-full mx-auto px-4 sm:px-6 lg:px-8 py-6 bg-gray-200 rounded-lg min-h-screen shadow-lg">
                <nav @class([
                    'text-sm font-semibold text-gray-700 mb-4',
                    'hidden' => request()->routeIs('home'),                    
                ]) aria-label="Breadcrumb">
                    <ol class="list-reset flex">
                        <li>
                            <a href="{{ route('home') }}" class="text-blue-500 hover:underline">Inicio</a>
                        </li>
                        @if (View::hasSection('ruta-anterior'))
                            <li><span class="mx-2">/</span></li>
                            <li class="text-gray-500">
                                <a href="@yield('url')">@yield('ruta-anterior')</a>
                            </li>
                        @endif
                        @if (View::hasSection('ruta-actual'))
                            <li><span class="mx-2">/</span></li>
                            <li class="text-gray-500">
                                @yield('ruta-actual')
                            </li>
                        @endif
                    </ol>
                </nav>
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
    <script src="{{ asset('js/historial-ventas.js') }}" ></script>
    <script>
        if(sessionStorage.getItem('pdf-toast')){
            toastLoading();
        }
    </script>
    @if (request()->routeIs('producto.update.view') || request()->routeIs('producto.update'))
        <script src="{{ asset('js/edit-productorep.js') }}"></script>
    @endif
</body>

</html>
