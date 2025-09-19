@extends('layouts.app')
@section('titulo', 'Reportes')
@section('ruta-actual', 'Reportes')

@section('contenido')
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4 p-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Reportes</h2>
            <p class="text-gray-600 text-sm">Administra tu inventario de productos y servicios</p>
        </div>
    </div>
    <div class="flex">
        <!-- Main Content -->
        <div class="flex-1 flex flex-col">

            <!-- Main Content Area -->
            <main class="flex-1 p-4">
                <!-- Filtros -->
                <div class="bg-white rounded-lg shadow p-4 mb-6">
                    <div class="flex flex-wrap items-center justify-between">
                        <h2 class="text-lg font-semibold text-gray-700">Filtros</h2>
                        <div class="flex flex-wrap gap-2">
                            <select class="border rounded-lg px-3 py-2 text-sm">
                                <option>Últimos 7 días</option>
                                <option>Últimos 30 días</option>
                                <option>Este mes</option>
                                <option>Mes anterior</option>
                            </select>
                            <select class="border rounded-lg px-3 py-2 text-sm">
                                <option>Todos los usuarios</option>
                                <option>Cajero 1</option>
                                <option>Cajero 2</option>
                            </select>
                            <button
                                class="bg-primary hover:bg-secondary text-white px-4 py-2 rounded-lg text-sm flex items-center">
                                <i class="fas fa-filter mr-1"></i> Aplicar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- KPIs -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                    <!-- Ventas totales -->
                    <div class="bg-white rounded-lg shadow p-6">
                        @if (session('caja'))
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-blue-100 text-primary">
                                    <i class="fas fa-shopping-cart text-xl"></i>
                                </div>
                                <div class="mx-4">
                                    <h4 class="text-gray-500 text-sm">Ventas hoy</h4>
                                    <div class="text-2xl font-bold">Gs.
                                        {{ number_format($data['ventas_hoy']['saldo'], 0, ',', '.') }}</div>
                                </div>
                            </div>
                            <div class="mt-4 text-green-500 text-sm flex items-center">
                                <i class="fas fa-arrow-up mr-1"></i>
                                <span>{{ $data['ventas_hoy']['tag'] }}{{ $data['ventas_hoy']['porcentaje'] }}% respecto almespasado</span>
                            </div>
                        @else
                        <div class="text-center h-full">                            
                            <span> Sin Caja abierta</span>
                        </div>
                        @endif
                    </div>

                    <!-- Clientes nuevos -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 text-accent">
                                <i class="fas fa-user-plus text-xl"></i>
                            </div>
                            <div class="mx-4">
                                <h4 class="text-gray-500 text-sm">Clientes nuevos</h4>
                                <div class="text-2xl font-bold">{{ $data['clientes_nuevos']['nuevos'] }}</div>
                            </div>
                        </div>
                        <div class="mt-4 text-green-500 text-sm flex items-center">
                            <i class="fas fa-arrow-up mr-1"></i>
                            <span>{{ $data['clientes_nuevos']['tag'] }}{{ $data['clientes_nuevos']['porcentaje'] }}%
                                respecto al mes pasado</span>
                        </div>
                    </div>

                    <!-- Productos más vendidos -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-purple-100 text-purple-500">
                                <i class="fas fa-box-open text-xl"></i>
                            </div>
                            <div class="mx-4">
                                <h4 class="text-gray-500 text-sm">Top producto</h4>
                                <div class="text-2xl font-bold">{{ $data['producto_vendido']['producto']->nombre }}</div>
                            </div>
                        </div>
                        <div class="mt-4 text-gray-500 text-sm">
                            {{ $data['producto_vendido']['cantidad'] }} unidades vendidas
                        </div>
                    </div>
                </div>

                <!-- Gráficos -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                    <!-- Evolución de ventas -->
                    <div class="lg:col-span-2 bg-white rounded-lg shadow p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-700">Evolución de Ventas</h3>
                            <div class="flex space-x-2 bg-gray-300 px-1 py-0.5 rounded-lg">
                                <button id="7d" data-periodo="7"
                                    class="periodo-btn cursor-pointer text-xs px-3 py-1  transition-all duration-300 ease-in-out bg-gray-50 font-semibold rounded-md shadow-lg">7D</button>
                                <button id="30d" data-periodo="30"
                                    class="periodo-btn cursor-pointer text-xs px-3 py-1 transition-all duration-300 ease-in-out bg-gray-300 font-semibold rounded-md">30D</button>
                                <button id="90d" data-periodo="90"
                                    class="periodo-btn cursor-pointer text-xs px-3 py-1 transition-all duration-300 ease-in-out bg-gray-300 font-semibold rounded-md">90D</button>
                            </div>
                        </div>
                        <div class="h-100">
                            <div class="h-full flex items-end space-x-2">
                                <canvas id="ventasChart">
                                    <div class="flex gap-4">
                                        <canvas id="ingresos"></canvas>
                                    </div>
                                </canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Formas de pago -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">Formas de Pago</h3>
                            <div class="flex space-x-2 bg-gray-300 px-1 py-0.5 rounded-lg mb-4">
                                <button id="7dp" data-pago="7"
                                    class="pago-btn cursor-pointer text-xs px-3 py-1  transition-all duration-300 ease-in-out bg-gray-50 font-semibold rounded-md shadow-lg">7D</button>
                                <button id="30dp" data-pago="30"
                                    class="pago-btn cursor-pointer text-xs px-3 py-1 transition-all duration-300 ease-in-out bg-gray-300 font-semibold rounded-md">30D</button>
                                <button id="90dp" data-pago="90"
                                    class="pago-btn cursor-pointer text-xs px-3 py-1 transition-all duration-300 ease-in-out bg-gray-300 font-semibold rounded-md">90D</button>
                            </div>
                        </div>

                        <canvas id="pagosChart">
                            <div class="flex gap-4">
                                <canvas id="transferencias"></canvas>
                                <canvas id="efectivo"></canvas>
                                <canvas id="mixto"></canvas>
                            </div>
                        </canvas>
                    </div>
                </div>

                <!-- Productos más vendidos y Alertas -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                    <!-- Top productos -->
                    <div class="lg:col-span-2 bg-white rounded-lg shadow p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-700">Productos Más Vendidos</h3>
                            <button class="text-primary text-sm flex items-center">
                                Ver todos <i class="fas fa-arrow-right ml-1"></i>
                            </button>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Producto</th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Categoría</th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Ventas</th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Stock</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($data['productos_vendidos'] as $producto)
                                        <tr>
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10 bg-gray-200 rounded-md"></div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $producto->nombre }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $producto->tipo }}</td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $producto->ventas }}</td>
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">{{ $producto->stock }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Alertas -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">Alertas</h3>
                        <div class="space-y-4">
                            <div class="p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-exclamation-triangle text-yellow-500"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h4 class="text-sm font-medium text-yellow-800">Stock bajo</h4>
                                        <p class="text-sm text-yellow-700">Auriculares Bluetooth: 3 unidades</p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-3 bg-blue-50 border border-blue-200 rounded-lg">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-info-circle text-blue-500"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h4 class="text-sm font-medium text-blue-800">Nueva venta</h4>
                                        <p class="text-sm text-blue-700">Venta de $2,450 registrada</p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-3 bg-red-50 border border-red-200 rounded-lg">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-exclamation-circle text-red-500"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h4 class="text-sm font-medium text-red-800">Venta inusual</h4>
                                        <p class="text-sm text-red-700">Venta de $8,750 detectada</p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-3 bg-green-50 border border-green-200 rounded-lg">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-check-circle text-green-500"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h4 class="text-sm font-medium text-green-800">Caja cerrada</h4>
                                        <p class="text-sm text-green-700">Cierre de caja completado</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="mt-4 w-full py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm text-gray-700">
                            Ver todas las alertas
                        </button>
                    </div>
                </div>

                <!-- Reportes -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-700">Reportes</h3>
                        <div class="flex space-x-2">
                            <button class="px-3 py-1 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm flex items-center">
                                <i class="fas fa-file-export mr-1"></i> Exportar
                            </button>
                            <button
                                class="px-3 py-1 bg-primary hover:bg-secondary text-white rounded-lg text-sm flex items-center">
                                <i class="fas fa-download mr-1"></i> Descargar PDF
                            </button>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                            <div class="flex items-center">
                                <div class="p-2 bg-blue-100 text-primary rounded-lg">
                                    <i class="fas fa-file-invoice text-xl"></i>
                                </div>
                                <div class="ml-4">
                                    <h4 class="font-medium">Reporte de Ventas</h4>
                                    <p class="text-sm text-gray-500">Ventas detalladas por periodo</p>
                                </div>
                            </div>
                        </div>
                        <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                            <div class="flex items-center">
                                <div class="p-2 bg-green-100 text-accent rounded-lg">
                                    <i class="fas fa-cash-register text-xl"></i>
                                </div>
                                <div class="ml-4">
                                    <h4 class="font-medium">Movimientos de Caja</h4>
                                    <p class="text-sm text-gray-500">Aperturas, cierres y diferencias</p>
                                </div>
                            </div>
                        </div>
                        <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                            <div class="flex items-center">
                                <div class="p-2 bg-purple-100 text-purple-500 rounded-lg">
                                    <i class="fas fa-boxes text-xl"></i>
                                </div>
                                <div class="ml-4">
                                    <h4 class="font-medium">Reporte de Stock</h4>
                                    <p class="text-sm text-gray-500">Inventario y productos bajos</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>



@endsection
