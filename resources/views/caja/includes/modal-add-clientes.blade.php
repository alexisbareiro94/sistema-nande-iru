<div id="modal-add-cliente"
    class="hidden fixed inset-0 bg-black/20 flex items-center justify-center z-40 transition-opacity duration-300 ">
    <div class="bg-white rounded-2xl w-full max-w-4xl shadow-2xl overflow-hidden flex flex-col ">

        <!-- Header -->
        <div class="flex bg-amarillo justify-between items-center p-4 border-b border-white">
            <h2 class="text-xl font-semibold text-gray-100">Agregar Cliente</h2>
            <button id="cerrar-modal-add-cliente"
                class="cursor-pointer text-gray-100 hover:text-gray-700 text-2xl font-bold">&times;</button>
        </div>

        <!-- Formulario -->
        <form id="form-add-cliente" class="p-6 flex flex-col gap-6 overflow-y-auto">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Nombre -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                    <input type="text" id="name" name="name" placeholder="Ingrese nombre"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400">
                </div>

                <!-- Apellido -->
                <div>
                    <label for="surname" class="block text-sm font-medium text-gray-700 mb-1">Apellido</label>
                    <input type="text" id="surname" name="surname" placeholder="Ingrese apellido"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400">
                </div>
            </div>

            <!-- Razon Social -->
            <div>
                <label for="razon_social" class="block text-sm font-medium text-gray-700 mb-1">
                    Razón Social <span class="text-red-500">*</span>
                </label>
                <input type="text" id="razon_social" name="razon_social" placeholder="Ingrese razón social"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400">
            </div>

            <!-- RUC o CI -->
            <div>
                <label for="ruc_ci" class="block text-sm font-medium text-gray-700 mb-1">
                    RUC o CI <span class="text-red-500">*</span>
                </label>
                <input type="text" id="ruc_ci" name="ruc_ci" placeholder="Ingrese RUC o CI"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400">
            </div>

            <!-- Botones -->
            <div class="flex justify-end gap-4 mt-4">
                <button type="button" id="cancelar-a-c"
                    class="px-6 py-2 bg-gray-200 font-semibold rounded-lg hover:bg-gray-300 cursor-pointer">
                    Cancelar
                </button>
                <button type="submit"
                    class="cursor-pointer px-5 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-lg">
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
