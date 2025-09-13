@extends('layouts.app')

@section('ruta-anterior', 'Caja')
@section('url', '/caja')
@section('ruta-actual', 'Historial de Movimientos')

@section('titulo', 'Historial de ventas')

@section('contenido')
    <!-- Filtros y Estadísticas -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4 p-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Historial de Movimientos</h2>
            <p class="text-gray-600 text-sm">Administra tu inventario de productos y servicios</p>
        </div>
        <a href="{{ route('producto.add') }}"
            class="flex items-center gap-2 cursor-pointer text-lg bg-gray-800 hover:bg-gray-900 text-gray-200 px-4 py-2 font-semibold rounded-lg shadow transition text-center whitespace-nowrap">
            <span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>

            </span>
            Nueva Venta
        </a>
    </div>
    <!-- Estadísticas -->
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
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                        viewBox="0 0 24 24">
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
                {{-- prox feat: agergar funcion de exportar a pdf y excel con o sin filtros --}}
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
            <div id="egresos-filtro" class="hidden flex gap-2 bg-red-200 px-2 py-1 rounded-lg items-center text-sm  text-red-800">                <svg class="w-6 h-6 text-red-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 4.5V19a1 1 0 0 0 1 1h15M7 10l4 4 4-4 5 5m0 0h-3.207M20 15v-3.207" />
                </svg>
                <span id="monto-egresos-filtro">
                    egresos: 1254654
                </span>
            </div>

            <div class="relative">
                <button id="export-btn"
                    class="flex items-center gap-2 bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200"
                    type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Exportar
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>

                <!-- Dropdown de opciones -->
                <div id="export-dropdown"
                    class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-30 hidden border border-gray-200">
                    <button
                        class="flex items-center w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-100 transition-colors"
                        onclick="exportToExcel()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-4 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Exportar a Excel
                    </button>
                    <button
                        class="flex items-center w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-100 transition-colors"
                        onclick="exportToPdf()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-4 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 14.25h10.5A2.625 2.625 0 0 0 21 16.875V12.75m0 0-2.625-2.625m2.625 2.625v2.625m-2.625 0H8.25m2.625 0V16.875m0-14.25V12.75m0 0-2.625-2.625m2.625 2.625v2.625m-2.625 0H8.25m2.625 0V16.875m0-14.25V12.75m0 0-2.625-2.625m2.625 2.625v2.625m-2.625 0H8.25m2.625 0V16.875m0-14.25V12.75m0 0-2.625-2.625m2.625 2.625v2.625m-2.625 0H8.25m2.625 0V16.875m0-14.25V12.75m0 0-2.625-2.625m2.625 2.625v2.625m-2.625 0H8.25m2.625 0V16.875m0-14.25V12.75m0 0-2.625-2.625m2.625 2.625v2.625m-2.625 0H8.25m2.625 0V16.875m0-14.25V12.75m0 0-2.625-2.625m2.625 2.625v2.625m-2.625 0H8.25m2.625 0V16.875m0-14.25V12.75m0 0-2.625......" />
                        </svg>
                        Exportar a PDF
                    </button>
                </div>
            </div>
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
                            @include('caja.historial-completo.icons.fecha')
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Cliente
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Productos/concepto
                        </th>
                        <th class="flex px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Total
                            @include('caja.historial-completo.icons.total')
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
    <script src="{{ asset('js/historial-ventas.js') }}"></script>
    <script src="{{ asset('js/detalle-movimiento.js') }}"></script>
@endsection
@include('caja.historial-completo.detalle-venta')
@include('caja.historial-completo.detalle-movimiento')
@endsection
