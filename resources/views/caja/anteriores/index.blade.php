@extends('layouts.app')
@section('titulo', 'Historias de Cajas')
@section('ruta-anterior', 'Caja')
@section('url', '/caja')
@section('ruta-actual', 'Historial de Cajas')

@section('contenido')
    <div class="flex flex-col md:flex-row md:items-center mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Historial de Cajas</h2>
            <p class="text-gray-600 text-sm mt-1">Gestiona y visualiza el historial de todas las cajas</p>
        </div>
    </div>

    <!-- Filtros -->
    <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
        <div class="flex flex-col md:flex-row gap-3 mb-10">
            <div class="flex flex-col md:flex-row gap-3 flex-grow">
                <input type="date"
                    class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <input type="date"
                    class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <select
                    class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option>Todos los cajeros</option>
                    <option>Cajero 1</option>
                    <option>Cajero 2</option>
                </select>
                <button
                    class="bg-gray-800 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Buscar
                </button>
            </div>
        </div>


        <!-- Cards de Cajas -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($cajas as $caja)
                <div
                    class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow overflow-hidden">
                    <!-- Header del Card -->
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-4 py-3 border-b border-gray-100">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-bold text-gray-900">Caja #{{ $caja->id }}</h3>
                                <p class="text-sm text-gray-600">{{ $caja->user->name }}</p>
                            </div>
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                        {{ $caja->estado == 'cerrado' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                {{ $caja->estado == 'cerrado' ? 'Cerrada' : 'Abierta' }}
                            </span>
                        </div>
                    </div>

                    <!-- Body del Card -->
                    <div class="p-4">
                        <div class="space-y-3">
                            <!-- Fechas -->
                            <div class="grid grid-cols-2 gap-2 text-sm">
                                <div>
                                    <p class="text-gray-500">Apertura</p>
                                    <p class="font-medium">{{ format_time($caja->fecha_apertura) }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Cierre</p>
                                    <p class="font-medium">
                                        {{ $caja->estado == 'cerrado' ? format_time($caja->fecha_cierre) : 'Pendiente' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Montos -->
                            <div class="space-y-2 pt-2">
                                <div class="flex justify-between items-center py-1">
                                    <span class="text-gray-600 text-sm">Esperado</span>
                                    <span class="font-semibold text-green-600">Gs.
                                        {{ moneda($caja->saldo_esperado) }}</span>
                                </div>
                                <div class="flex justify-between items-center py-1">
                                    <span class="text-gray-600 text-sm">Encontrado</span>
                                    <span class="font-semibold text-blue-600">Gs. {{ moneda($caja->monto_cierre) }}</span>
                                </div>
                                <div class="flex justify-between items-center py-1">
                                    <span class="text-gray-600 text-sm">Egresos</span>
                                    <span class="font-semibold text-red-600">Gs. {{ moneda($caja->egresos) }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-t border-gray-100 mt-2">
                                    <span class="font-medium text-gray-900">Saldo Final</span>
                                    <span class="font-bold text-lg text-gray-900">Gs.
                                        {{ moneda($caja->monto_cierre - $caja->egresos) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer del Card -->

                    @if (session('caja') && session('caja')['id'] == $caja->id)
                    @else
                        <div class="bg-gray-50 px-4 py-3 flex justify-end space-x-2">
                            <button data-cajaid="{{ $caja->id }}"
                                class="detalle-caja cursor-pointer text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Ver
                            </button>
                            <button class="bt-pdf flex items-center cursor-pointer">
                                <svg class="w-4.5 h-4.5 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M5 17v-5h1.5a1.5 1.5 0 1 1 0 3H5m12 2v-5h2m-2 3h2M5 10V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1v6M5 19v1a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-1M10 3v4a1 1 0 0 1-1 1H5m6 4v5h1.375A1.627 1.627 0 0 0 14 15.375v-1.75A1.627 1.627 0 0 0 12.375 12H11Z" />
                                </svg>

                                PDF
                            </button>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    @include('caja.anteriores.modal-detalle')
@section('js')
    <script src="{{ asset('js/historial-caja.js') }}"></script>
@endsection
@endsection
