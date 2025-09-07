<div id="modalCierreCaja" class="hidden fixed inset-0 bg-black/20 backdrop-blur-xs flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl w-full max-w-md shadow-2xl p-6 space-y-6">
        
        <!-- Encabezado -->
        <div class=" flex justify-between items-center pb-2 border-b">
            <h2 class="text-xl font-bold text-gray-800">Cierre de Caja</h2>
            <button id="btn-cierre-caja" class="cursor-pointer text-gray-400 hover:text-gray-600 text-2xl leading-none transition-colors">
                &times;
            </button>
        </div>

        <!-- Información del cajero -->
        <div id="info-turno">
            <div class="bg-blue-50 rounded-lg p-4 border border-blue-100">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <h3 class="font-semibold text-blue-800">Información del turno</h3>
                </div>
                <div class="text-sm text-gray-700 space-y-1">
                    <p class="text-gray-800 font-semibold">Cajero: <span id="nombre-cc" class="font-normal"> Cargando...</span></p>
                    <p class="text-gray-800 font-semibold">Apertura: <span id="fecha-cc" class="font-normal"> Cargando...</span></p>
                </div>
            </div>
        </div>

        <!-- Resumen financiero -->
        <div class="space-y-3">
            <h3 class="font-semibold text-gray-800 border-b pb-2">Resumen financiero</h3>
            
            <div class="grid grid-cols-2 gap-3 text-sm">
                <div class="bg-gray-50 rounded-lg p-3">
                    <p class="text-gray-600">Monto inicial</p>
                    <p id="monto-inicial-cc" class="font-semibold text-gray-800">0 Gs</p>
                </div>
                <div class="bg-green-50 rounded-lg p-3 border border-green-100">
                    <p class="text-green-700">Ingresos</p>
                    <p id="ingresos-cc" class="font-semibold text-green-800">0 Gs</p>
                </div>
                <div class="bg-red-50 rounded-lg p-3 border border-red-100">
                    <p class="text-red-700">Egresos</p>
                    <p id="egresos-cc" class="font-semibold text-red-800">0 Gs</p>
                </div>
                <div class="bg-blue-50 rounded-lg p-3 border border-blue-100">
                    <p class="text-blue-700">Saldo esperado</p>
                    <p id="saldo-esperado" class="font-bold text-blue-800 text-lg">0 Gs</p>
                </div>
            </div>
        </div>

        <!-- Conteo y diferencia -->
        <div class="space-y-4">
            <div>
                <label class="block mb-2 font-medium text-gray-700">Monto contado en caja</label>
                <input id="montoContado" placeholder="Efectivo + transferencias" type="number" 
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
            </div>

            <div class="bg-yellow-50 rounded-lg p-4 border border-yellow-200">
                <div class="flex justify-between items-center">
                    <span class="font-medium text-yellow-800">Diferencia:</span>
                    <span id="diferencia" class="font-bold text-lg text-yellow-700">0 Gs</span>
                </div>
            </div>
        </div>

        <!-- Observaciones -->
        <div>
            <label class="block mb-2 font-medium text-gray-700">Observaciones</label>
            <textarea id="observaciones" placeholder="Detalles adicionales del cierre..." 
                      class="w-full border border-gray-300 rounded-lg px-4 py-3 h-20 resize-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"></textarea>
        </div>

        <!-- Botones de acción -->
        <div class="flex gap-3 pt-2">
            <button id="btn-cancelar-cierre" class="flex-1 px-4 py-3 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium transition-colors">
                Cancelar
            </button>
            <button id="confirmar-cierre" class="flex-1 px-4 py-3 rounded-lg bg-green-600 hover:bg-green-700 text-white font-medium transition-colors shadow-md hover:shadow-lg">
                Confirmar cierre
            </button>
        </div>
    </div>
</div>
<script>
    const btnscc = document.querySelectorAll('#btn-cancelar-cierre, #btn-cierre-caja');    
    btnscc.forEach(btn => {
        btn.addEventListener('click', () => {
            document.getElementById('modalCierreCaja').classList.add('hidden')
        });
    });
</script>