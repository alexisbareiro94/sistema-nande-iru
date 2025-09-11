<!-- Modal Detalle de Venta -->
<div id="modal-detalle-venta"
    class="hidden opacity-0  transition-opacity duration-150 fixed inset-0 backdrop-blur-xs bg-black/20 items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-screen overflow-y-auto">
        <!-- Header del Modal -->
        <div class="border-b px-6 py-4 flex justify-between items-center">
            <h2 id="d-v-codigo" class="text-xl font-bold text-gray-900">Detalle de Venta #V-001</h2>
            <!-- datos del cajero -->
            <div class="flex justify-between gap-1 bg-gray-200 px-2 py-0.5 rounded-xl">
                <span class="font-semibold">Cajero:</span>
                <p id="dv-cajero">adda</p>
            </div>
            <!-- boton para cerrar el modal -->
            <button onclick="cerrarModalDetalle()" class="cursor-pointer text-gray-400 hover:text-gray-600">
                <span class="text-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </span>
            </button>            
        </div>

        <!-- Contenido del Modal -->
        <div class="p-6">            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <h3 id="dv-info-venta" class="text-lg font-medium text-gray-900 mb-3">Información de la Venta</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Fecha:</span>
                            <span id="d-v-fecha" class="font-medium">Cargando...</span>
                        </div>
                        <div id="dv-estado-cont" class="flex justify-between">
                            <span class="text-gray-600">Estado:</span>
                            <span id="d-v-estado"
                                class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">Completado</span>
                        </div>
                        <div id="dv-met-pago-cont" class="flex justify-between">
                            <span class="text-gray-600">Método de Pago:</span>
                            <div class="flex gap-2 relative">
                                <span id="d-v-pago" class="font-medium">Cargando...</span>
                                <span id="svg-mixto" class="hidden cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                    </svg>

                                </span>

                                <!-- si hace un pago mixto -->
                                <div id="d-v-if-mixto"
                                    class="hidden absolute z-50 top-8 right-0 w-auto min-w-[280px] bg-gray-100 0 shadow-xl rounded-lg border border-gray-300  overflow-hidden">
                                    <div class="p-4 border-b border-gray-200 ">
                                        <h3 class="text-sm font-semibold text-gray-900 ">Resumen de Pagos
                                        </h3>
                                    </div>
                                    <div class="p-4 space-y-3">
                                        <div class="flex justify-between items-center py-2">
                                            <div class="flex items-center">
                                                <div class="w-2 h-2 rounded-full bg-blue-500 mr-2"></div>
                                                <span class="text-sm text-gray-600">Transferencia</span>
                                            </div>
                                            <span id="d-v-mixto-transf" class="text-sm font-medium text-gray-900 ">Gs.
                                                160.000</span>
                                        </div>

                                        <div class="flex justify-between items-center py-2">
                                            <div class="flex items-center">
                                                <div class="w-2 h-2 rounded-full bg-green-500 mr-2"></div>
                                                <span class="text-sm text-gray-600 300">Efectivo</span>
                                            </div>
                                            <span id="d-v-mixto-efectivo" class="text-sm font-medium text-gray-900 ">Gs.
                                                460.000</span>
                                        </div>
                                    </div>
                                    <div class="px-4 py-3 bg-gray-100  border-t border-gray-200">
                                        <div class="flex justify-between">
                                            <span class="text-sm font-medium text-gray-700 ">Total</span>
                                            <span id="d-v-total-mixto" class="text-sm font-bold text-gray-900 ">Gs.
                                                620.000</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 id="dv-info-cli" class="text-lg font-medium text-gray-900 mb-3">Información del Cliente</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Nombre:</span>
                            <span id="d-v-razon" class="font-medium">Cargando...</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">RUC:</span>
                            <span id="d-v-ruc" class="font-medium">Cargando...</span>
                        </div>
                        {{-- <div class="flex justify-between">
                            <span class="text-gray-600">Teléfono:</span>
                            <span class="font-medium">Cargando...</span>
                        </div> --}}
                    </div>
                </div>
            </div>

            <!-- Tabla de Productos -->
            <div class="mb-6">
                <h3 id="dv-concepto" class="text-lg font-medium text-gray-900 mb-3">Productos</h3>
                <div id="table-container" class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Producto</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Código</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Cantidad</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Precio Unitario</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Subtotal</th>
                            </tr>
                        </thead>
                        <tbody id="d-v-bodyTable" class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                    Cargando...
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">Cargando...</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">Cargando...</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">Cargando...</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">Cargando...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Totales -->
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="space-y-2">
                    <div id="dv-descuento" class="hidden flex justify-between">
                        <span class=" text-gray-600">Descuento:</span>
                        <span id="dv-subtotal" class="font-medium">Cargando...</span>
                    </div>
                    <div class="flex justify-between border-t border-gray-300 pt-2">
                        <span class="text-lg font-bold text-gray-900">Total:</span>
                        <span id="d-v-total" class="text-lg font-bold text-gray-900">Cargando...</span>
                    </div>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="flex justify-end space-x-3 mt-6">
                <button
                    class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
                    <i class="fas fa-print mr-2"></i>
                    Imprimir
                </button>
                <button class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors">
                    <i class="fas fa-file-pdf mr-2"></i>
                    Exportar PDF
                </button>
            </div>
        </div>
    </div>
</div>
