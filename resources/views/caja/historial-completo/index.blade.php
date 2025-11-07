@extends('layouts.app')

@section('ruta-anterior', 'Caja')
@section('url', '/caja')
@section('ruta-actual', 'Historial de Movimientos')

@section('titulo', 'Historial de ventas')

@section('contenido')
    <!-- Filtros y Estadísticas -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4 p-6">
        @if (auth()->user()->role === 'admin')
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Historial de Movimientos</h2>
                <p class="text-gray-600 text-sm">Administra tu inventario de productos y servicios</p>
            </div>
        @else
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Tu historial de Movimientos <span class="text-sm font-normal"> |
                        {{ ucfirst(auth()->user()->name) }}</span></h2>
            </div>
        @endif
    </div>
    <!-- Estadísticas -->
    @if (auth()->user()->role === 'admin')
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100">
                        <i class="fas fa-shopping-cart text-blue-600 text-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                            </svg>

                        </i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Ventas</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $totalVentas }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100">
                        <i class="fas fa-dollar-sign text-green-600 text-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                            </svg>

                        </i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Ingresos por venta</p>
                        <p class="text-2xl font-semibold text-gray-900">Gs. {{ number_format($ingresos, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100">
                        <i class="fas fa-calendar-alt text-yellow-600 text-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                            </svg>

                        </i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Hoy</p>
                        <p class="text-2xl font-semibold text-gray-900">Gs. {{ number_format($ingresosHoy, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100">
                        <i class="fas fa-users text-purple-600 text-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                            </svg>

                        </i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Clientes</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $clientes }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtros -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="p-6">
                <div class="flex justify-between">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Filtros de Búsqueda</h3>
                    <span id="dv-borrar-filtros" title="Borrar filtros" class="hidden group cursor-pointer">
                        <svg class="w-[34px] h-[34px]  bg-red-500 shadow-lg text-white transition-all duration-200 group-hover:text-white group-hover:bg-gray-800 rounded-full"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2"
                                d="M14.5 8.046H11V6.119c0-.921-.9-1.446-1.524-.894l-5.108 4.49a1.2 1.2 0 0 0 0 1.739l5.108 4.49c.624.556 1.524.027 1.524-.893v-1.928h2a3.023 3.023 0 0 1 3 3.046V19a5.593 5.593 0 0 0-1.5-10.954Z" />
                        </svg>

                    </span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fecha Desde</label>
                        <input id="dv-desde" type="date"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fecha Hasta</label>
                        <input id="dv-hasta" type="date"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                        <select id="dv-i-estado"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Todos</option>
                            <option value="completado">Completado</option>
                            <option value="pendiente">Pendiente</option>
                            <option value="cancelado">Cancelado</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Forma de pago</label>
                        <select id="dv-forma-pago"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Todos</option>
                            <option value="transferencia">Transferencia</option>
                            <option value="efectivo">Efectivo</option>
                            <option value="mixto">Mixto</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipo</label>
                        <select id="dv-tipo"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Todos</option>
                            <option value="venta">Venta</option>
                            <option value="sin_descuento">Venta sin descuento</option>
                            <option value="con_descuento">Venta con descuento</option>
                            <option value="venta-ingreso">Ventas e Ingreso</option>
                            <option value="ingreso">Ingreso</option>
                            <option value="egreso">Egreso</option>
                        </select>
                    </div>

                    <div class="flex items-end">
                        <button id="dv-buscar"
                            class="w-full bg-gray-800 hover:bg-gray-800 cursor-pointer text-white px-4 py-2 rounded-md transition-colors">
                            <i class="fas fa-search mr-2"></i>
                            Buscar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- Tabla de Ventas -->
    <div class="bg-white rounded-lg shadow items-center">
        <div class="px-6 py-4 border-b border-gray-200 flex gap-5 items-center">
            <div class="relative">
                <span class="absolute z-20 left-2 top-2 pr-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>

                </span>
                <input id="dv-input-s" class="min-w-xs border border-gray-400 pl-11 py-2 rounded-md"
                    placeholder="Ingrese codigo de venta o cliente" type="text" name="">
            </div>
            <div id="ingresos-filtro"
                class="hidden flex gap-2 bg-green-200 px-2 py-1 rounded-lg items-center text-sm  text-green-800">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5m.75-9 3-3 2.148 2.148A12.061 12.061 0 0 1 16.5 7.605" />
                </svg>
                <span id="monto-ingresos-filtro">
                    ingresos: 23510000
                </span>
            </div>
            <div id="egresos-filtro"
                class="hidden flex gap-2 bg-red-200 px-2 py-1 rounded-lg items-center text-sm  text-red-800"> <svg
                    class="w-6 h-6 text-red-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                    height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 4.5V19a1 1 0 0 0 1 1h15M7 10l4 4 4-4 5 5m0 0h-3.207M20 15v-3.207" />
                </svg>
                <span id="monto-egresos-filtro">
                    egresos: 1254654
                </span>
            </div>

            <!-- dropdown -->
            @if (auth()->user()->role === 'admin')
                <div class="relative">
                    <div id="dropdown" tabindex="0" role="button"
                        class="group flex items-center gap-2 px-3 py-2 bg-white border rounded-md shadow-sm cursor-pointer select-none focus:outline-none focus:ring-2 focus:ring-gray-500">
                        <span class="text-sm font-medium text-gray-700 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                width="24" height="24" viewBox="0 0 256 256">
                                <image
                                    xlink:href="data:image/png;base64,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"
                                    x="0" y="0" width="256" height="256" />
                            </svg>
                            Exportar
                        </span>
                        <svg id="icon-flecha" class="w-4 h-4 transition-transform rotate-180"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>

                    <div class="relative">
                        <!-- Menu -->
                        <div id="export-menu"
                            class="absolute z-[999] hidden opacity-0 transition-all duration-150 -right-1.5 top-1 mt-2 w-48 rounded-md border bg-white shadow-lg">
                            <div class="py-1" role="menu" aria-orientation="vertical"
                                aria-labelledby="options-menu">
                                <button id="export-pdf" tabindex="0" role="menuitem"
                                    class="w-full cursor-pointer px-4 py-2 text-sm font-semibold text-gray-700 bg-red-50 transition-colors duration-150 hover:bg-red-200 focus:bg-red-400 flex justify-between">
                                    PDF
                                    <span class="">
                                        <svg class="w-6 h-6 text-gray-800 " aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="1.7"
                                                d="M5 17v-5h1.5a1.5 1.5 0 1 1 0 3H5m12 2v-5h2m-2 3h2M5 10V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1v6M5 19v1a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-1M10 3v4a1 1 0 0 1-1 1H5m6 4v5h1.375A1.627 1.627 0 0 0 14 15.375v-1.75A1.627 1.627 0 0 0 12.375 12H11Z" />
                                        </svg>

                                    </span>
                                </button>
                                <a href="{{ route('venta.excel') }}" tabindex="0" role="menuitem"
                                    class="px-4 py-2 text-sm font-semibold text-gray-700 bg-green-50 transition-colors duration-150 hover:bg-green-200 focus:bg-green-400 flex justify-between">
                                    EXCEL
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            width="24" height="24" viewBox="0 0 256 256">
                                            <image
                                                xlink:href="data:image/png;base64,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"
                                                x="0" y="0" width="256" height="256" />
                                        </svg>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif


        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            tipo
                        </th>
                        <th class="flex px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Fecha
                            @if (auth()->user()->role === 'admin')
                                @include('caja.historial-completo.icons.fecha')
                            @endif
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Cliente
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Productos/concepto
                        </th>
                        <th class="flex px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Total
                            @if (auth()->user()->role === 'admin')
                                @include('caja.historial-completo.icons.total')
                            @endif
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Estado
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody id="dv-body-tabla" class="bg-white divide-y divide-gray-200">
                    @foreach ($ventas as $venta)
                        @if ($venta->venta != null)
                            @include('caja.historial-completo.includes.venta')
                        @else
                            @include('caja.historial-completo.includes.movimiento')
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div id="paginacion" class="min-w-full px-6 py-4 bg-white border-t border-gray-200 ">
            {{ $ventas->links() }}
        </div>
    </div>

@section('js')
    <script src="{{ asset('js/detalle-movimiento.js') }}"></script>
@endsection
@include('caja.historial-completo.detalle-venta')
@include('caja.historial-completo.detalle-movimiento')
@endsection
