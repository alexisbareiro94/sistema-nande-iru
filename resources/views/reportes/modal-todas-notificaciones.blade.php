    <!-- Modal Detalle de Caja -->
    <div id="todas-notificaciones-modal"
        class="fixed hidden inset-0 flex backdrop-blur-xs bg-black/20 z-50 items-center justify-center transition-all duration-300 ease-in-out">
        <div
            class="bg-white rounded-2xl shadow-2xl w-full max-w-6xl max-h-[90vh] overflow-hidden flex flex-col transform transition-transform duration-300 scale-95">
            <!-- Header del Modal -->
            <div class="border-b px-6 py-4 flex justify-between items-center bg-white">
                <div>
                    <h2 id="dc-detalle-caja" class="text-2xl font-bold text-gray-800">Todas las notificaciones</h2>
                </div>
                <button id="cerrar-notificaciones" class="cursor-pointer text-gray-500 hover:text-gray-700 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Contenido del Modal -->
            <div class="overflow-y-auto flex-grow ">
                <div id="all-notif-cont" class="p-6 grid grid-cols-3 gap-4 ">
                    <div
                        class="col col-span-1 p-3 shadow-md transition-all duration-300 transform bg-blue-50 rounded-md border border-blue-400">
                        <div class="flex relative">
                            <div class="ml-3 ">
                                <h4 class="text-sm font-medium text-${item.color}-800">${item.titulo}</h4>
                                <p class="text-sm text-${item.color}-700">${item.mensaje}</p>
                                <span
                                    class="text-xs absolute top-0 text-${item.color}-500 right-0">${fechaFormateada}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center p-8">
                <button id="cargar-mas" class="px-3 py-2 rounded-lg font-semibold bg-gray-200 cursor-pointer transition-all duration-200 hover:bg-gray-300">
                    Cargar mas
                </button>
            </div>
        </div>
    </div>
