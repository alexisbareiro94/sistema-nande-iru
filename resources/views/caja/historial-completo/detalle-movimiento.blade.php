<!-- Modal Detalle de Venta -->
<div id="modal-detalle-movimiento"
    class=" hidden opacity-0  transition-opacity duration-150 fixed inset-0 backdrop-blur-xs bg-black/20 items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-screen overflow-y-auto">
        <!-- Header del Modal -->
        <div class="border-b px-6 py-4 flex justify-between items-center">
            <h2 id="dm-codigo" class="text-xl font-bold text-gray-900">Detalle del movimiento</h2>
            <button onclick="cerrarmodalDmDetalleMov()" class="cursor-pointer text-gray-400 hover:text-gray-600">
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
                    <h3 id="dm-info-mov" class="text-lg font-medium text-gray-900 mb-3">Información del movimiento</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Fecha:</span>
                            <span id="dm-fecha" class="font-medium">Cargando...</span>
                        </div>
                        <div id="dm-tipo-cont" class="flex justify-between">
                            <span class="text-gray-600">tipo:</span>
                            <span id="dm-tipo"
                                class="">Completado</span>
                        </div>                        
                    </div>
                </div>

                <div>
                    <h3 id="dm-info-turno" class="text-lg font-medium text-gray-900 mb-3">Información del Turno</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Cajero:</span>
                            <span id="dm-cajero" class="font-medium">Cargando...</span>
                        </div>
                        {{-- <div class="flex justify-between">
                            <span class="text-gray-600">RUC:</span>
                            <span id="dm-ruc" class="font-medium">Cargando...</span>
                        </div> --}}
                    </div>
                </div>
            </div>

            <!-- Tabla de Productos -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Concepto</h3>
                <div class="overflow-x-auto">
                    <li id="dm-concepto" > Pago a proveedor </li>
                </div>
            </div>

            <!-- Totales -->
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="space-y-2">                    
                    <div class="flex justify-between border-t border-gray-300 pt-2">
                        <span class="text-lg font-bold text-gray-900">Total:</span>
                        <span id="dm-total" class="text-lg font-bold text-gray-900">Cargando...</span>
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
