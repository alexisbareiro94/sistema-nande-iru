@extends('layouts.app')

@section('titulo', 'caja')

@section('ruta-actual', 'Caja')

@section('contenido')
    <header class="flex justify-between md:flex-row md:items-center mb-6 gap-4">
        <div class="flex items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Gestión de Caja</h2>
            </div>
            @if (auth()->user()->role == 'admin')
                <div>
                    <a href="{{ route('caja.anteriores') }}"
                        class="text-sm bg-gray-200 hover:underline text-gray-600 hover:text-gray-800 px-3 py-1.5 rounded-lg transition">
                        Ver Cajas Anteriores
                    </a>
                </div>
            @endif
        </div>
    </header>

    <div class="flex flex-col">
        <div class="bg-white rounded-xl shadow-sm overflow-hidden p-4">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Panel izquierdo - Estado y controles -->
                <div class="lg:col-span-2 bg-white p-6">
                    <!-- Estado actual de la caja -->
                    <div class="bg-gray-50 rounded-xl p-6 mb-6 border border-gray-200">
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-4">
                            <!-- Estado de la caja -->
                            <div class="flex-1">
                                <div class="flex flex-wrap items-center gap-3 mb-4">
                                    <span @class([
                                        'inline-flex items-center px-4 py-1.5 rounded-full text-sm font-semibold',
                                        'bg-red-100 text-red-800' => empty(session('caja')),
                                        'bg-green-100 text-green-800' => session('caja'),
                                    ])>
                                        {{ session('caja') ? 'CAJA ABIERTA' : 'CAJA CERRADA' }}
                                    </span>
                                    <span class="text-gray-600 text-sm">
                                        @if (session('caja'))
                                            Última apertura: {{ format_time(session('caja')['fecha_apertura']) }} |
                                            {{ session('caja')['user']['name'] ?? '' }}
                                        @else
                                            @if ($caja == null)
                                                Aún no se registró ninguna caja
                                            @else
                                                Último cierre: {{ format_time($caja->fecha_cierre) }} |
                                                {{ $caja->user->name }}
                                            @endif
                                        @endif
                                    </span>
                                </div>
                                <!-- Saldo actual -->
                                @if (auth()->user()->role === 'admin')
                                    <div class="bg-white rounded-lg p-5 border border-gray-200 shadow-sm">
                                        <p class="text-gray-600 text-sm mb-2">Saldo actual</p>
                                        <p id="saldo-caja" class="text-3xl font-bold text-gray-800">
                                            <svg id="loader-saldo" class="animate-spin h-8 w-8 text-gray-400"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                                    stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z">
                                                </path>
                                            </svg>
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Botones principales -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Botón Abrir/Cerrar Caja -->
                        @if (auth()->user()->role === 'admin')
                            <button {{ !session('caja') ? 'id=btn-abrir-caja' : 'id=btn-cerrar-caja' }}
                                @class([
                                    'cursor-pointer text-white font-semibold py-4 rounded-lg transition-all duration-200 hover:shadow-md',
                                    'bg-green-600 hover:bg-green-700' => empty(session('caja')),
                                    'bg-red-600 hover:bg-red-700' => session('caja'),
                                ])>
                                <div class="flex flex-col items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mb-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2M3 12h18M5 10h14a2 2 0 012 2v7a2 2 0 01-2 2H5a2 2 0 01-2-2v-7a2 2 0 012-2z" />
                                    </svg>
                                    <span>{{ session('caja') ? 'Cerrar Caja' : 'Abrir Caja' }}</span>
                                </div>
                            </button>


                            <!-- Botón Movimientos Manuales -->
                            <div class="relative">
                                <button {{ !session('caja') ? 'disabled' : '' }} id="btn-movimiento"
                                    class="cursor-pointer w-full bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-4 rounded-lg
                                    transition-all duration-200 hover:shadow-md disabled:cursor-not-allowed">
                                    <div class="flex flex-col items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mb-1" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        <span>Movimientos Manuales</span>
                                    </div>
                                </button>

                                @if (!session('caja'))
                                    <div
                                        class="absolute  inset-0 bg-gray-100/70 rounded-lg flex items-center justify-center backdrop-blur-[2px]">
                                        <span class="text-gray-500 text-sm font-medium">Caja cerrada</span>
                                    </div>
                                @endif
                            </div>
                        @endif
                        <!-- Botón Ir a Ventas -->
                        <div class="relative">
                            <button id="ir-a-ventas"
                                class="cursor-pointer w-full bg-gray-800 hover:bg-gray-600 text-white font-semibold py-4 rounded-lg
                                    transition-all duration-200 hover:shadow-md" {{ !session('caja') ? 'disabled' : ''}}>
                                <div class="flex flex-col items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mb-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <span>Ir a Ventas</span>
                                </div>
                            </button>

                            @if (!session('caja'))
                                <div
                                    class="absolute inset-0 bg-gray-100/70 rounded-lg flex items-center justify-center backdrop-blur-[2px]">
                                    <span class="text-gray-500 text-sm font-medium">Caja cerrada</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Panel derecho - Historial de movimientos -->
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Historial de Movimientos</h3>
                    @include('caja.includes.movimientos')
                </div>
            </div>
        </div>

        <!-- graficos -->
        @if (Auth::user()->role == 'admin')
            <div class="bg-white rounded-xl shadow-sm overflow-hidden p-6 mt-4 h-auto">
                @include('caja.graficos.graficos')
            </div>
        @endif

        @include('caja.includes.modal-venta')
        @include('caja.includes.modal-abrir-caja')
        @include('caja.includes.modal-add-clientes')
        @include('caja.venta-completada')
        @include('caja.movimientos-manuales')
        @include('caja.carrar-caja')
        @include('caja.includes.cargando')
    </div>

@section('js')
    <script src="{{ asset('js/caja.js') }}"></script>
    <script src="{{ asset('js/procesar-caja.js') }}"></script>
    <script src="{{ asset('js/movimiento.js') }}"></script>
@endsection
@endsection
