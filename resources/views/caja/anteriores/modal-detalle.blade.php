<!-- Modal Detalle de Caja -->
<div id="modal-detalle-caja"
    class="fixed hidden inset-0 flex backdrop-blur-xs bg-black/20 z-50 items-center justify-center pointer-events-none transition-all duration-300 ease-in-out">
    <div
        class="bg-white rounded-2xl shadow-2xl w-full max-w-6xl max-h-[90vh] overflow-hidden flex flex-col transform transition-transform duration-300 scale-95">
        <!-- Header del Modal -->
        <div class="border-b px-6 py-4 flex justify-between items-center bg-gradient-to-r from-blue-50 to-indigo-50">
            <div>
                <h2 id="dc-detalle-caja" class="text-2xl font-bold text-gray-800">Detalle de Caja #C-001</h2>
                <p id="dc-cajero-fechas" class="text-gray-600 text-sm">Juan Pérez - 15/01/2024 08:00 - 15/01/2024 18:00</p>
            </div>
            <button onclick="cerrarModalCaja()" class="cursor-pointer text-gray-500 hover:text-gray-700 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Contenido del Modal -->
        <div class="overflow-y-auto flex-grow">
            <div class="p-6">
                <!-- Resumen Financiero -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-xl p-4">
                        <div class="flex items-center">
                            <div class="p-2 bg-green-500 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-gray-600">Esperado</p>
                                <p id="dc-monto-esperado" class="text-xl font-bold text-gray-900">Gs. 1,250,000</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-xl p-4">
                        <div class="flex items-center">
                            <div class="p-2 bg-blue-500 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-gray-600">Encontrado</p>
                                <p id="dc-monto-encontrado" class="text-xl font-bold text-gray-900">Gs. 1,245,000</p>
                            </div>
                        </div>
                    </div>

                    <div id="dif-cont-one" class="bg-gradient-to-br from-red-50 to-red-100 border border-red-200 rounded-xl p-4">
                        <div class="flex items-center">
                            <div id="dif-cont-dos" class="p-2 bg-red-500 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-gray-600">Diferencia</p>
                                <p id="dc-diferencia" class="text-xl font-bold text-red-600">Gs. -5,000</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200 rounded-xl p-4">
                        <div class="flex items-center">
                            <div class="p-2 bg-purple-500 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-gray-600">Transacciones</p>
                                <p id="dc-transacciones" class="text-xl font-bold text-gray-900">45</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Estadísticas de Ventas -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                    <!-- Gráfico de Métodos de Pago -->
                    <div class="lg:col-span-2 bg-white border border-gray-200 rounded-xl p-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Métodos de Pago</h3>
                        <div class="space-y-3">
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-gray-600">Efectivo</span>
                                    <span id="dc-efectivo" class="font-medium">Gs. 850,000 (68%)</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div id="dc-ef-por" class="bg-green-500 h-2 rounded-full"></div>
                                </div>
                            </div>                            
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-gray-600">Transferencia</span>
                                    <span id="dc-transferencia" class="font-medium">Gs. 75,000 (32%)</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div id="dc-tr-por" class="bg-blue-500 h-2 rounded-full" ></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Estadísticas Rápidas -->
                    <div class="bg-white border border-gray-200 rounded-xl p-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Estadísticas</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Ticket Promedio</span>
                                <span id="dc-promedio" class="font-bold text-gray-900">Gs. 27,778</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Mayor Venta</span>
                                <span id="dc-mayor-venta" class="font-bold text-gray-900">4.5</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Clientes Únicos</span>
                                <span id="dc-clientes" class="font-bold text-gray-900">38</span>
                            </div>                         
                        </div>
                    </div>
                </div>

                <!-- Productos Más Vendidos -->
                <div class="bg-white border border-gray-200 rounded-xl p-4 mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Productos Más Vendidos</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-gray-600 font-medium">Producto</th>
                                    <th class="px-4 py-2 text-left text-gray-600 font-medium">Cantidad</th>
                                    <th class="px-4 py-2 text-left text-gray-600 font-medium">Importe</th>
                                    {{-- <th class="px-4 py-2 text-left text-gray-600 font-medium">% Ventas</th> --}}
                                </tr>
                            </thead>
                            <tbody id="dc-tabla-body" class="divide-y divide-gray-200">
                                <tr>
                                    <td class="px-4 py-2 font-medium">Laptop Dell Inspiron</td>
                                    <td class="px-4 py-2">8</td>
                                    <td class="px-4 py-2">Gs. 960,000</td>
                                    <td class="px-4 py-2">
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">22%</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-medium">Mouse Inalámbrico</td>
                                    <td class="px-4 py-2">15</td>
                                    <td class="px-4 py-2">Gs. 225,000</td>
                                    <td class="px-4 py-2">
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">18%</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-medium">Teclado Mecánico</td>
                                    <td class="px-4 py-2">12</td>
                                    <td class="px-4 py-2">Gs. 180,000</td>
                                    <td class="px-4 py-2">
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">15%</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Egresos -->
                <div class="bg-white border border-gray-200 rounded-xl p-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Egresos</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center p-3 bg-red-50 rounded-lg">
                            <div>
                                <p class="font-medium text-gray-900">Compra de Insumos</p>
                                <p class="text-sm text-gray-600">15/01/2024 14:30</p>
                            </div>
                            <span class="font-bold text-red-600">Gs. 150,000</span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-red-50 rounded-lg">
                            <div>
                                <p class="font-medium text-gray-900">Pago a Proveedor</p>
                                <p class="text-sm text-gray-600">15/01/2024 16:45</p>
                            </div>
                            <span class="font-bold text-red-600">Gs. 200,000</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer del Modal -->
        <div class="border-t px-6 py-4 flex justify-end space-x-3 bg-gray-50">
            <button
                class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 transition flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Imprimir
            </button>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Exportar PDF
            </button>
        </div>
    </div>
</div>