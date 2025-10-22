<div id="modal-add-cliente"
    class="hidden fixed inset-0 bg-black/20 flex items-center justify-center z-40 transition-opacity duration-300 ">
    <div class="bg-white rounded-2xl w-full max-w-4xl shadow-2xl overflow-hidden flex flex-col ">

        <!-- Header -->
        <div class="flex bg-white justify-between items-center p-4 border-b border-gray-400">
            <h2  class="text-xl font-semibold text-gray-800">Agregar Cliente</h2>
            <button id="cerrar-modal-add-cliente"
                class="cursor-pointer text-gray-800 hover:text-gray-400 text-2xl font-bold">&times;</button>
        </div>

        <!-- Formulario -->
        <form id="form-add-cliente" class="p-6 flex flex-col gap-6 overflow-y-auto">            
            <!-- Razon Social -->
            <div>
                <label for="razon_social" class="block text-sm font-medium text-gray-700 mb-1">
                    Nombre o Razón Social <span class="text-red-500">*</span>
                </label>
                <input type="text" id="razon_social" name="razon_social" placeholder="Ingrese razón social"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-400 focus:border-gray-400">
            </div>

            <!-- RUC o CI -->
            <div>
                <label for="ruc_ci" class="block text-sm font-medium text-gray-700 mb-1">
                    RUC o CI <span class="text-red-500">*</span>
                </label>
                <input type="text" id="ruc_ci" name="ruc_ci" placeholder="Ingrese RUC o CI"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-400 focus:border-gray-400">
            </div>
            <!-- correo-->
            <div>
                <label for="correo-c" class="block text-sm font-medium text-gray-700 mb-1">
                    Correo <span class="text-red-500">*</span>
                </label>
                <input type="text" id="correo-c" name="correo-c" placeholder="Ingrese razón social"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-400 focus:border-gray-400">
            </div>
            <!-- telefono-->
            <div>
                <label for="telefono-c" class="block text-sm font-medium text-gray-700 mb-1">
                    Telefono <span class="text-red-500">*</span>
                </label>
                <input type="text" id="telefono-c" name="telefono-c" placeholder="Ingrese razón social"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-400 focus:border-gray-400">
            </div>
            <!-- Botones -->
            <div class="flex justify-end gap-4 mt-4">
                <button type="button" id="cancelar-a-c"
                    class="px-6 py-2 bg-gray-200 font-semibold rounded-lg hover:bg-gray-300 cursor-pointer">
                    Cancelar
                </button>
                <button type="submit"
                    class="cursor-pointer px-5 py-2 bg-gray-800 hover:bg-gray-600 text-white font-semibold rounded-lg">
                    Guardar
                </button>
            </div>
        </form>
    </div>

    <script>
        const cancelar = document.querySelectorAll('#cerrar-modal-add-cliente, #cancelar-a-c');

        cancelar.forEach(btn => {
            btn.addEventListener('click', () => {
                document.getElementById('modal-add-cliente').classList.add('hidden');
            })
        })
    </script>
</div>
