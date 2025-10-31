@extends('layouts.app')

@section('titulo', 'home')

@section('contenido')
    <header class="bg-gray-300 text-black shadow-md">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <p></p>

            <nav class="space-x-4 flex">
                <a href="" class="hover:text-[#CC0000] font-semibold">Perfil</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="hover:text-[#CC0000] font-semibold cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                        </svg>
                    </button>
                </form>
            </nav>
        </div>
    </header>
    <div class="max-w-7xl mx-auto p-6 pt-8">
        <div class="mb-10">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Panel de Control</h1>
            @if (auth()->check() && !auth()->user()->temp_used && auth()->user()->role == 'admin')
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4" role="alert">
                    <p class="font-bold">Cuenta temporal</p>
                    <p>Esta cuenta es temporal y vencerá el
                        <strong>{{ format_time(auth()->user()->expires_at) }}</strong>.
                        Por favor, configurá tu cuenta permanente antes de esa fecha.
                    </p>
                    <a href="{{ route('auth.config.view') }}" class="text-blue-600 underline font-medium hover:text-blue-800">
                        Configurar ahora
                    </a>
                </div>
            @endif
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Clientes y Distribuidores -->
            <a id="gestion-cl-dis" href="{{ route('cliente.dist.index') }}"
                class="group bg-gradient-to-b from-white to-gray-50 border border-gray-100 rounded-xl overflow-hidden transition-all duration-300 hover:shadow-2xl hover:-translate-y-1 hover:shadow-blue-100/50 min-h-[180px] flex flex-col items-center p-6">
                <div class="bg-blue-50 rounded-full p-4 mb-4 group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="h-8 w-8 text-blue-600">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>

                </div>
                <span class="text-lg font-medium text-gray-800 text-center group-hover:text-blue-600 transition-colors">
                    Gestión de Clientes y Distribuidores
                </span>
            </a>

            <!-- Caja -->
            <a href="{{ route('caja.index') }}"
                class="group bg-gradient-to-b from-white to-gray-50 border border-gray-100 rounded-xl overflow-hidden transition-all duration-300 hover:shadow-2xl hover:-translate-y-1 hover:shadow-green-100/50 min-h-[180px] flex flex-col items-center p-6">
                <div class="bg-green-50 rounded-full p-4 mb-4 group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="h-8 w-8 text-green-600">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>

                </div>
                <span
                    class="text-lg font-medium text-gray-800 text-center group-hover:text-green-600 transition-colors">Caja</span>
            </a>

            <!-- Inventario -->
            <a href="{{ route('producto.index') }}"
                class="group bg-gradient-to-b from-white to-gray-50 border border-gray-100 rounded-xl overflow-hidden transition-all duration-300 hover:shadow-2xl hover:-translate-y-1 hover:shadow-yellow-100/50 min-h-[180px] flex flex-col items-center p-6">
                <div class="bg-yellow-50 rounded-full p-4 mb-4 group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="h-8 w-8 text-yellow-600">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                    </svg>

                </div>
                <span
                    class="text-lg font-medium text-gray-800 text-center group-hover:text-yellow-600 transition-colors">Inventario</span>
            </a>

            <!-- Gestión de Usuarios -->
            @if (Auth::user()->role == 'admin')
                <div class="relative">
                    <a href="{{ route('gestion.index.view') }}"
                        class="group bg-gradient-to-b from-white to-gray-50 border border-gray-100 rounded-xl overflow-hidden transition-all duration-300 hover:shadow-2xl hover:-translate-y-1 hover:shadow-purple-100/50 min-h-[180px] flex flex-col items-center p-6">
                        <div class="bg-purple-50 rounded-full p-4 mb-4 group-hover:scale-110 transition-transform">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="h-8 w-8 text-purple-600">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>

                        </div>
                        <span
                            class="text-lg font-medium text-gray-800 text-center group-hover:text-purple-600 transition-colors">Gestión
                            de Usuarios</span>
                    </a>
                </div>
            @endif
            <!-- Reportes -->
            @if (Auth::user()->role == 'admin')
                <div class="relative">
                    @if (Auth::user()->notificaciones->where('is_read', false)->count() > 0)
                        <span
                            class="absolute -top-2 -right-2 z-40 bg-gradient-to-t from-red-300 to-red-500 border border-red-400 px-3 py-1 rounded-full text-white font-black animate-bounce">
                            {{ Auth::user()->notificaciones->where('is_read', false)->count() }}
                        </span>
                    @endif
                    <a id="reportes-index" href="{{ route('reporte.index') }}"
                        class="group bg-gradient-to-b from-white to-gray-50 border border-gray-100 rounded-xl overflow-hidden transition-all duration-300 hover:shadow-2xl hover:-translate-y-1 hover:shadow-red-100/50 min-h-[180px] flex flex-col items-center p-6">
                        <div class="bg-red-50 rounded-full p-4 mb-4 group-hover:scale-110 transition-transform">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="h-8 w-8 text-red-600">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941" />
                            </svg>

                        </div>
                        <span
                            class="text-lg font-medium text-gray-800 text-center group-hover:text-red-600 transition-colors">Reportes</span>
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
