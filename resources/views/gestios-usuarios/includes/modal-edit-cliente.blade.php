<div id="modal-edit-cliente"
    class="hidden fixed inset-0 bg-black/20 backdrop-blur-xs flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl w-full max-w-md shadow-2xl p-6 space-y-6">

        <!-- Encabezado -->
        <div class=" flex justify-between items-center pb-2 border-b">
            <h2 class="text-xl font-bold text-gray-800">Editar Usuario</h2>
            <button id="cerrar-modal-edit-cliente"
                class="cursor-pointer text-gray-400 hover:text-gray-600 text-2xl leading-none transition-colors">
                &times;
            </button>
        </div>

        <div class="space-y-3">
            <form class="max-w-sm mx-auto" id="form-edit-cliente-gcd">
                <input type="hidden" name="user-id" id="user-id" value="">
                <div class="mb-5">
                    <label for="razon-gcd" class="block mb-2 text-sm font-medium text-gray-900 ">Razón social</label>
                    <input type="razon-gcd" id="razon-gcd"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        placeholder="name@flowbite.com" required />
                </div>
                <div class="mb-5">
                    <label for="ruc-ci-gcd" class="block mb-2 text-sm font-medium text-gray-900 ">
                        RUC - CI</label>
                    <input type="text" id="ruc-ci-gcd"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        required />
                </div>

                <!-- Botones de acción -->
                <div class="flex gap-3 pt-2">
                    <button id="btn-cancelar-cierre"
                        class="flex-1 px-4 py-3 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium transition-colors">
                        Cancelar
                    </button>
                    <button type="submit" id="confirmar-cierre"
                        class="cursor-pointer transition-all active:scale-90 flex-1 px-4 py-3 rounded-lg bg-green-600 hover:bg-green-700 text-white font-medium shadow-md hover:shadow-lg">
                        Confirmar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
