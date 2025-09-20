@extends('layouts.app')
@section('titulo', 'Reportes')
@section('ruta-actual', 'Reportes')

@section('contenido')
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-2 gap-4 p-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Reportes</h2>
            <p class="text-gray-600 text-sm">Administra tu inventario de productos y servicios</p>
        </div>

        <div
            class="flex items-center gap-2  text-lg bg-gray-800 text-gray-200 px-4 py-2 font-semibold rounded-lg">            
            {{ \Carbon\Carbon::parse(now())->format('d / m / Y') }}
        </div>
    </div>
    <div class="flex">
        <div class="flex-1 flex flex-col">
            <main class="flex-1 p-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                    <!-- Ventas totales -->
                    <div class="bg-white rounded-lg shadow p-6">
                        @if (session('caja'))
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-blue-100 text-primary">
                                    <i class="fas fa-shopping-cart text-xl"></i>
                                </div>
                                <div class="mx-4">
                                    <h4 class="text-gray-500 text-sm">Ventas de Este Mes</h4>
                                    <div class="text-2xl font-bold">Gs.
                                        {{ number_format($data['ventas_hoy']['saldo'], 0, ',', '.') }}</div>
                                </div>
                            </div>
                            <div class="mt-4 text-green-500 text-sm flex items-center">
                                <i class="fas fa-arrow-up mr-1"></i>
                                <span>{{ $data['ventas_hoy']['tag'] }}{{ $data['ventas_hoy']['porcentaje'] }}% respecto hasta mismo dia del mes pasado</span>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <span class="text-gray-500 font-medium">No hay ninguna caja abierta</span>
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
                            <div class="flex space-x-2 bg-gray-300  rounded-lg">
                                <button id="7d" data-periodo="7"
                                    class="periodo-btn cursor-pointer text-xs px-3 py-1 transition-all duration-300 ease-in-out border border-gray-300 bg-gray-50 font-semibold rounded-md shadow-lg">7D</button>
                                <button id="30d" data-periodo="30"
                                    class="periodo-btn cursor-pointer text-xs px-3 py-1 transition-all duration-300 ease-in-out border border-gray-300 bg-gray-300 font-semibold rounded-md">30D</button>
                                <button id="90d" data-periodo="90"
                                    class="periodo-btn cursor-pointer text-xs px-3 py-1 transition-all duration-300 ease-in-out border border-gray-300 bg-gray-300 font-semibold rounded-md">90D</button>
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
                    <div class="bg-white rounded-lg shadow p-6 flex-col">
                        <div class="h-40  mx-auto items-center mb-12">
                            <div class="flex justify-between items-center">
                                <h3 class="text-md font-semibold text-gray-700 mb-2">Formas de Pago</h3>
                                <div class="flex space-x-2 bg-gray-300  rounded-lg">
                                    <button id="7dp" data-pago="7"
                                        class="pago-btn cursor-pointer text-xs px-3 py-1  transition-all duration-300 ease-in-out border border-gray-300 bg-gray-50 font-semibold rounded-md shadow-lg">7D</button>
                                    <button id="30dp" data-pago="30"
                                        class="pago-btn cursor-pointer text-xs px-3 py-1 transition-all duration-300 ease-in-out border border-gray-300 bg-gray-300 font-semibold rounded-md">30D</button>
                                    <button id="90dp" data-pago="90"
                                        class="pago-btn cursor-pointer text-xs px-3 py-1 transition-all duration-300 ease-in-out border border-gray-300 bg-gray-300 font-semibold rounded-md">90D</button>
                                </div>
                            </div>
                            <canvas id="pagosChart" class=""></canvas>
                        </div>

                        <div class="h-40  mx-auto items-center mb-7">
                            <div class="flex justify-between items-center">
                                <h3 class="text-md font-semibold text-gray-700 mb-4">Tipo de Venta</h3>
                                <div class="flex space-x-2 bg-gray-300  rounded-lg">
                                    <button id="7dp" data-tipo="7"
                                        class="tipo-btn cursor-pointer text-xs px-3 py-1  transition-all duration-300 ease-in-out border border-gray-300 bg-gray-50 font-semibold rounded-md shadow-lg">7D</button>
                                    <button id="30dp" data-tipo="30"
                                        class="tipo-btn cursor-pointer text-xs px-3 py-1 transition-all duration-300 ease-in-out border border-gray-300 bg-gray-300 font-semibold rounded-md">30D</button>
                                    <button id="90dp" data-tipo="90"
                                        class="tipo-btn cursor-pointer text-xs px-3 py-1 transition-all duration-300 ease-in-out border border-gray-300 bg-gray-300 font-semibold rounded-md">90D</button>
                                </div>
                            </div>
                            <canvas id="tipoVentaChart" class=""></canvas>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6 min-h-20 my-6">

                    <!-- Selector de periodo -->
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-md font-semibold text-gray-700 mb-4">Reportes de Utilidad por Rango de Fechas</h3>
                        <div class="flex justify-center flex-1 gap-4">
                            <div class="flex space-x-2 bg-gray-300 rounded-lg">
                                <button id="7dp" data-utilidad="dia"
                                    class="utilidad-btn cursor-pointer text-xs px-3 py-1 transition-all duration-300 ease-in-out border border-gray-300 bg-gray-50 font-semibold rounded-md shadow-lg">Diario</button>
                                <button id="30dp" data-utilidad="semana"
                                    class="utilidad-btn cursor-pointer text-xs px-3 py-1 transition-all duration-300 ease-in-out border border-gray-300 bg-gray-300 font-semibold rounded-md">Semana</button>
                                <button id="90dp" data-utilidad="mes"
                                    class="utilidad-btn cursor-pointer text-xs px-3 py-1 transition-all duration-300 ease-in-out border border-gray-300 bg-gray-300 font-semibold rounded-md">Mensual</button>
                            </div>

                            <div class="flex gap-2">
                                <div class="flex space-x-2 bg-gray-300 rounded-lg">
                                    <button 
                                        class="option-btn cursor-pointer text-xs px-3 py-1 transition-all duration-300 ease-in-out border border-gray-300 bg-gray-50 font-semibold rounded-md shadow-lg">NO</button>
                                    <button  data-option="hoy"
                                        class="option-btn cursor-pointer text-xs px-3 py-1 transition-all duration-300 ease-in-out border border-gray-300 bg-gray-300 font-semibold rounded-md">SI</button>
                                </div>
                                <span class="text-xs text-gray-600 italic text-center">Compararlo con hasta el mismo dia </span>
                            </div>
                        </div>
                    </div>
                    <!-- Contenedor de métricas -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <!-- Ganancia Actual -->
                        <div id="" class="bg-gradient-to-r from-blue-50 to-blue-100 p-4 rounded-lg border border-blue-200">
                            <p class="text-sm text-gray-500">Ganancia Actual</p>
                            <p id="ganancia-actual" class="text-2xl font-bold text-blue-700">Gs.
                                {{ number_format($data['utilidad']['actual']['ganancia'], 0, ',', '.') }}</p>
                            <p id="rango-actual" class="text-xs text-gray-500 mt-1">Rango: Hoy
                                ({{ Carbon\Carbon::parse($data['utilidad']['actual']['fecha_apertura'])->format('d-m') }})
                            </p>
                        </div>
                        
                        <!-- Comparación con periodo anterior -->
                        <div id="cont-diff" @class([
                                'bg-gradient-to-r p-4 rounded-lg border', 
                                'from-red-50 to-red-100 border-red-200' => $data['utilidad']['tag'] === '-',
                                'from-green-50 to-green-100 border-green-200' => $data['utilidad']['tag'] === '+',
                            ])>
                            <p class="text-sm text-gray-500">vs Periodo Anterior</p>
                            <div class="flex items-center mt-1">
                                <span id="variacion-porcentaje" class="text-2xl font-bold {{ $data['utilidad']['tag'] == '+' ? 'text-green-700' : 'text-red-700' }}">
                                    {{ $data['utilidad']['tag'] }}{{ $data['utilidad']['porcentaje'] }}%</span>
                                <span class="ml-2 text-sm text-gray-600" id="variacion-valor">
                                    (Gs. {{ number_format($data['utilidad']['diferencia'], 0, ',', '.') }})
                                </span>
                            </div>
                            <p id="rango-anterior" class="text-xs text-gray-500 mt-1">Rango Anterior: Ayer
                                ({{ Carbon\Carbon::parse($data['utilidad']['pasado']['fecha_apertura'])->format('d-m') }})
                            </p>
                        </div>

                        <div
                            class="max-h-40 bg-gradient-to-r from-purple-50 to-purple-100 p-4 rounded-lg border border-purple-200 flex flex-col justify-center items-center">
                            <p>Tendencias</p>
                            <canvas id="miniChart" class="w-full h-32"></canvas> <!-- 128px -->

                        </div>
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


    <script>
        //     const btns = document.querySelectorAll('.periodo-utilidad-btn');
        //     const gananciaActualEl = document.getElementById('ganancia-actual');
        //     const rangoActualEl = document.getElementById('rango-actual');
        //     const variacionPorcentajeEl = document.getElementById('variacion-porcentaje');
        //     const variacionValorEl = document.getElementById('variacion-valor');
        //     const rangoAnteriorEl = document.getElementById('rango-anterior');
        //     const mensajeEl = document.getElementById('mensaje-utilidad');

        //     // Datos simulados (reemplazar con llamadas a API)
        //     const datosSimulados = {
        //         dia: {
        //             actual: 1250.50,
        //             anterior: 980.00,
        //             rangoActual: "Hoy (10 Abr)",
        //             rangoAnterior: "Ayer (9 Abr)"
        //         },
        //         semana: {
        //             actual: 8420.00,
        //             anterior: 7600.00,
        //             rangoActual: "Semana actual (8-14 Abr)",
        //             rangoAnterior: "Semana pasada (1-7 Abr)"
        //         },
        //         mes: {
        //             actual: 32000.00,
        //             anterior: 35000.00,
        //             rangoActual: "Abril 2025",
        //             rangoAnterior: "Marzo 2025"
        //         }
        //     };

        //     btns.forEach(btn => {
        //         btn.addEventListener('click', () => {
        //             // Reset estilo
        //             btns.forEach(b => b.classList.remove('bg-blue-500', 'text-white'));
        //             btn.classList.add('bg-blue-500', 'text-white');

        //             const periodo = btn.dataset.periodo;
        //             const data = datosSimulados[periodo];

        //             if (data) {
        //                 // Actualizar valores
        //                 gananciaActualEl.textContent = `$${data.actual.toLocaleString()}`;
        //                 rangoActualEl.textContent = data.rangoActual;

        //                 const diff = data.actual - data.anterior;
        //                 const porcentaje = ((diff / data.anterior) * 100).toFixed(1);

        //                 variacionValorEl.textContent = `(${diff >= 0 ? '+' : ''}$${diff.toLocaleString()})`;
        //                 variacionPorcentajeEl.textContent = `${diff >= 0 ? '+' : ''}${porcentaje}%`;

        //                 // Colores según variación
        //                 if (diff >= 0) {
        //                     variacionPorcentajeEl.classList.remove('text-red-700');
        //                     variacionPorcentajeEl.classList.add('text-green-700');
        //                 } else {
        //                     variacionPorcentajeEl.classList.remove('text-green-700');
        //                     variacionPorcentajeEl.classList.add('text-red-700');
        //                 }

        //                 rangoAnteriorEl.textContent = data.rangoAnterior;
        //                 mensajeEl.classList.add('hidden');
        //             } else {
        //                 mensajeEl.textContent = "Cargando datos...";
        //                 mensajeEl.classList.remove('hidden');
        //             }
        //         });
        //     });

        //     // Activar por defecto "Semanal"
        //     document.querySelector('[data-periodo="semana"]').click();
        // 
    </script>
@endsection
