<!-- Modal de Venta Mejorado -->
<div id="modal-ventas"
    class=" fixed inset-0 bg-black/60 flex items-center justify-center z-50 transition-opacity duration-300">
    <div class="bg-white rounded-2xl w-full max-w-7xl shadow-2xl overflow-hidden flex flex-col h-[90vh]">
        <!-- Header con título y botón de cierre -->
        <div class="bg-gradient-to-r from-yellow-500 to-amarillo p-4 flex justify-between items-center">
            <h2 class="text-white text-2xl font-bold flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Nueva Venta
            </h2>
            <!-- cerrar modal x -->
            <button id="cerrar-modal-ventas"
                class="text-white cursor-pointer hover:bg-yellow-700 rounded-full p-2 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="flex flex-1 overflow-hidden">
            <!-- Izquierda: Lista de productos -->
            <div class="w-2/3 p-3 flex flex-col">
                <!-- Buscador con icono -->
                <div class="relative mb-5">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <form id="form-b-productos-ventas" action="">
                        <input id="input-b-producto-ventas" type="text" placeholder="Buscar producto por nombre, código o categoría..."
                        class="w-full pl-12 pr-4 py-3 border border-gray-300  rounded-xl focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 transition-all">
                    </form>
                </div>

                <!-- Tabla de productos con mejor diseño -->
                <div class="overflow-y-auto rounded-xl border border-gray-200 shadow-sm flex-1">
                    <table class="w-full text-left">
                        <thead class="bg-gradient-to-r from-yellow-50 to-yellow-100 sticky top-0 z-10">
                            <tr class="text-yellow-800">
                                <th class="px-5 py-3 font-semibold">Producto</th>
                                <th class="px-5 py-3 font-semibold">Precio</th>
                                <th class="px-5 py-3 font-semibold">Stock</th>
                                <th class="px-5 py-3 font-semibold text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody id="tabla-venta-productos" class="divide-y divide-gray-100">
                            <!-- Ejemplo de fila -->
                            {{-- <tr class="hover:bg-yellow-50 transition-colors">
                                <td class="px-5 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="bg-yellow-100 p-2 rounded-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 5v2m0 4v2m0 4v2M5 8a2 2 0 012-2h10a2 2 0 012 2v14a2 2 0 01-2 2H7a2 2 0 01-2-2V8z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-medium">Vacuna contra la rabia</p>
                                            <p class="text-xs text-gray-500">Código: VAC-001</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-3 font-medium">90.000 Gs.</td>
                                <td class="px-5 py-3 text-green-600 font-medium">15 disponibles</td>
                                <td class="px-5 py-3 text-center">
                                    <button
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white w-9 h-9 rounded-full flex items-center justify-center transition-all shadow-md hover:shadow-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                    </button>
                                </td>
                            </tr> --}}
                            <!-- Más filas aquí -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Derecha: Carrito de venta -->
            <div class="w-1/3 p-2 flex flex-col gap-1 bg-gray-50 ">
                <!-- Información del cliente -->
                <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-200">
                    <h3 class="font-bold text-lg text-yellow-700 mb-3 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Cliente
                    </h3>

                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">RUC o CI</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 21h7a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H5a2 2 0 00-2 2v11a2 2 0 00.293 1.207l5.414 5.414A1 1 0 009.414 21z" />
                                    </svg>
                                </div>
                                <input type="text" placeholder="Ingrese RUC o CI"
                                    class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400">                                    
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nombre o Razón Social</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <input type="text" placeholder="Ingrese nombre o razón social"
                                    class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Carrito de compras -->
                <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-200 flex-1 flex flex-col">
                    <div class="flex justify-between items-center mb-3">
                        <h4 class="font-bold text-yellow-700 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Carrito
                        </h4>
                        <button
                            class="text-sm text-yellow-600 hover:text-yellow-800 font-medium flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Limpiar
                        </button>
                    </div>

                    <div id="carrito" class="flex-1 overflow-y-auto pr-1 space-y-1">
                        <!-- Ejemplo de producto en carrito -->
                        <div class="bg-gray-50 rounded-lg p-2 flex justify-between items-start">
                            <div class="flex-1">
                                <p class="text-xs font-semibold">Vacuna contra la rabia</p>
                                <p class="text-xs text-gray-500">Código: VAC-001</p>
                            </div>
                            <div class="flex items-center gap-0 ml-1">
                                <button
                                    class="w-5 h-5 rounded-md bg-yellow-100 text-yellow-700 flex items-center justify-center hover:bg-yellow-200 transition-colors">
                                    <span>-</span>
                                </button>
                                <span class="w-5 text-center font-medium">2</span>
                                <button
                                    class="w-5 h-5 rounded-md bg-yellow-500 text-white flex items-center justify-center hover:bg-yellow-600 transition-colors">
                                    <span>+</span>
                                </button>
                            </div>
                            <div class="ml-3 font-medium">180.000 Gs.</div>
                        </div>
                        <!-- Más productos aquí -->
                    </div>

                    <div class="border-t pt-4 mt-2">
                        <div class="flex justify-between items-center text-lg font-bold">
                            <span class="text-gray-600">TOTAL:</span>
                            <span id="totalCarrito" class="text-yellow-600 text-2xl">180.000 Gs.</span>
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="flex gap-3 pt-2">
                    <button id="cerrar-venta"
                        class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-3 rounded-xl transition-colors flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Cancelar
                    </button>
                    <button
                        class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 rounded-xl transition-colors shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Procesar Venta
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
