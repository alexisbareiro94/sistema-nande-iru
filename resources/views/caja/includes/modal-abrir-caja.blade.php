<div id="modalAbrirCaja" class="hidden fixed inset-0 bg-black/20 flex items-center justify-center z-50 ">
    <div class="bg-gray-100 rounded-2xl shadow-xl w-full max-w-md p-6 border border-gray-700 relative">
        
        <!-- Botón cerrar -->
        <button id="closeModal" class="absolute cursor-pointer top-3 right-3 text-gray-900 hover:text-gray-600 text-2xl">&times;</button>

        <!-- Contenido -->
        <h2 class="text-xl font-bold text-gray-800 mb-4 text-center">Abrir Caja</h2>

        <!-- Usuario autenticado -->
        <div class="flex items-center justify-center mb-4">
            <span class="text-gray-900 text-sm">Usuario: </span>
            <span class="text-gray-800 font-semibold ml-2">{{ auth()->user()->name }}</span>
        </div>

        <!-- Campo para monto inicial -->
        <form id="abrir-caja-form" action="{{ route('caja.abrir') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="monto_inicial" class="block text-gray-900 text-sm mb-2">Monto Inicial</label>
                <input  type="number" id="monto_inicial" name="monto_inicial" step="0.01"
                class="w-full px-4 py-2 rounded-lg bg-gray-200 text-black border border-gray-700 focus:border-gray-800 focus:ring focus:ring-gray-800/30 outline-none">
            </div>
            
            <!-- Botones -->
            <div class="flex justify-end gap-3">
                <button type="button" id="cancelarModal" class="px-4 py-2 rounded-lg bg-gray-200 text-gray-800 font-bold hover:bg-gray-300">
                    Cancelar
                </button>
                <button type="submit"  id="confirmarModal" class="px-4 py-2 rounded-lg bg-gray-800 text-gray-100 font-bold hover:bg-gray-700">
                    Confirmar
                </button>
            </div>
        </form>
    </div>
</div>
