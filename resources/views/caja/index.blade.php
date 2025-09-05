@extends('layouts.app')

@section('titulo', 'caja')

@section('contenido')
    <style>
        .card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid #25334a;
        }
    </style>

    <div class="min-h-screen text-gray-200 p-4 md:p-8">
        <div class="max-w-4xl mx-auto">
            <!-- Título del módulo -->
            <div class="text-center mb-8">
                <h1 class="pt-8 text-3xl font-bold text-gray-800">
                    Gestión de caja
                </h1>
            </div>

            <!-- Estado actual de la caja (Dashboard) -->
            <div class="card rounded-2xl p-6 mb-8 status-badge">
                <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                    <!-- Estado de la caja -->
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-4">

                            <span @class([
                                'inline-flex items-center px-4 py-1.5 rounded-full text-sm font-bold shadow-lg text-gray-900',
                                'bg-red-500' => empty(session('caja')),
                                'bg-amarillo' => session('caja'),
                            ])>
                                {{ session('caja') ? 'CAJA ABIERTA' : 'CAJA CERRADA' }}
                            </span>
                            <span class="text-gray-400 text-sm">
                                @if (session('caja'))
                                    Última apertura: {{ format_time(session('caja')['fecha_apertura']) }}
                                @else
                                    @if ($caja == null)
                                        Aun no se registro ninguna caja
                                    @else
                                        Último Cierre: {{ format_time($caja->fecha_cierre) }}
                                    @endif
                                @endif
                            </span>
                            <span class="text-gray-400 text-sm -ml-2">
                                | {{ session('caja')['user']['name'] ?? ''}}
                            </span>

                        </div>

                        <!-- Saldo actual -->
                        <div class="bg-gray-800 rounded-xl p-5 border border-gray-700">
                            <p class="text-gray-400 text-sm mb-1">Saldo actual</p>
                            <p id="saldo-caja" class="text-4xl font-bold text-amarillo">
                                Gs. {{ session('caja') ? number_format(session('caja')['saldo'], 0, ',', '.') : 0 }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones principales -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <button {{ !session('caja') ? 'id=btn-abrir-caja' : 'id=btn-cerrar-caja' }} @class([
                    'cursor-pointer text-white font-bold py-4 rounded-xl transition-all duration-300 transform hover:scale-[1.02] shadow-lg shadow-red-500/20',
                    'bg-amarillo hover:bg-yellow-500' => empty(session('caja')),
                    'bg-rojo hover:bg-red-700' => session('caja'),
                ])>
                    <div class="flex flex-col items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2M3 12h18M5 10h14a2 2 0 012 2v7a2 2 0 01-2 2H5a2 2 0 01-2-2v-7a2 2 0 012-2z" />
                        </svg>
                        <span> {{ session('caja') ? 'Cerrar Caja' : 'Abrir Caja' }}</span>
                    </div>
                </button>
                <!-- Botón Movimientos Manuales -->
                <div class="relative">
                    <button disabled
                        class="cursor-pointer w-full bg-gray-300 hover:bg-gray-400 text-gray-900 font-bold py-4 rounded-xl
                        transition-all duration-300 transform hover:scale-[1.02]">
                        <div class="flex flex-col items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-1" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            <span>Movimientos Manuales</span>
                        </div>
                    </button>

                    @if (!session('caja'))
                        <div
                            class="cursor-not-allowed absolute inset-0 z-50 backdrop-blur-xs bg-gray-500/80 rounded-xl flex flex-col items-center justify-center gap-2 text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" />
                            </svg>
                            <span class="text-lg font-semibold">Abrir Caja</span>
                        </div>
                    @endif
                </div>

                <!-- Botón Ir a Ventas -->
                <div class="relative">
                    <button id="ir-a-ventas"  
                        class="cursor-pointer h-full z-50 w-full bg-amarillo hover:bg-amber-400 text-gray-900 font-bold py-4 rounded-xl
                        transition-all duration-300 transform hover:scale-[1.02]">
                        <div class="flex flex-col items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-1" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span>Ir a Ventas</span>
                        </div>
                    </button>

                    @if (!session('caja'))
                        <div
                            class="cursor-not-allowed absolute inset-0 z-50 backdrop-blur-xs bg-gray-500/80 rounded-xl flex flex-col items-center justify-center gap-2 text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" />
                            </svg>
                            <span class="text-lg font-semibold">Abrir Caja</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Historial de movimientos (opcional) -->
            @include('caja.includes.movimientos')            
        </div>
    </div>
    @include('caja.includes.modal-venta')
    @include('caja.includes.modal-abrir-caja')
    @include('caja.includes.modal-add-clientes')    
    @include('caja.venta-completada')

@section('js')
    <script src="{{ asset('js/caja.js') }}"></script>
    <script src="{{ asset('js/procesar-caja.js') }}"></script>
    <script src="{{ asset('js/movimiento.js') }}"></script>
@endsection
@endsection
