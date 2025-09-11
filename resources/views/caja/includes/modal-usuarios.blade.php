<div id="modalUsuarios"
    class="hidden fixed inset-0 bg-black/20 flex items-start justify-center z-50 transition-opacity duration-300">
    <div class="bg-white rounded-lg w-96 max-h-[80vh] overflow-y-auto shadow-md p-5 mt-40 ml-10 border border-gray-200">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-800">Usuarios</h2>
            <button id="cerrarModal" class="text-gray-400 hover:text-gray-600 text-xl cursor-pointer transition-colors">&times;</button>
        </div>

        <!-- Lista de usuarios -->
        <ul id="listaUsuarios" class="space-y-3 mb-4">
            <li class="hover:bg-gray-50 px-3 py-3  cursor-pointer rounded-lg border border-gray-100 transition-colors">
                <p class="text-sm font-medium text-gray-800"> <strong>Nombre:</strong> Alexis bareiro</p>                
                <p class="text-sm text-gray-600"> <strong>RUC/CI:</strong> 56656454</p>
            </li>            
        </ul>

        <div class="flex items-center justify-center">
            <button id="registrar-cliente"
                class="cursor-pointer bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                Registrar Cliente
            </button>
        </div>
    </div>

    <script>
        document.getElementById('cerrarModal').addEventListener('click', () => {
            document.getElementById('modalUsuarios').classList.add('hidden')
        })

        document.getElementById('registrar-cliente').addEventListener('click', () => {
            document.getElementById('modal-add-cliente').classList.remove('hidden')
            document.getElementById('modalUsuarios').classList.add('hidden')
        })
    </script>
</div>