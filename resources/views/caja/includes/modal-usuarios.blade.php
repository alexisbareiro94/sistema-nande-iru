<div id="modalUsuarios"
    class="hidden fixed inset-0 bg-black/10 flex items-start justify-center z-50 transition-opacity duration-300">
    <div class="bg-white rounded-lg w-96 max-h-[80vh] overflow-y-auto shadow-lg p-4 mt-40 ml-10">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold">Usuarios</h2>
            <button id="cerrarModal" class="text-gray-500 hover:text-gray-700 text-xl cursor-pointer">&times;</button>
        </div>

        <!-- Lista de usuarios -->
        <ul id="listaUsuarios" class="space-y-2 mb-2">
            <li class="hover:bg-amarillo/20 px-2 py-2 cursor-pointer">
                <p> <strong> Nombre:</strong> Alexis bareiro</p>                
                <p> <strong> RUC/CI:</strong> 56656454</p>
            </li>            
        </ul>

        <div class="items-center justify-center text-center">
            <button id="registrar-cliente"
                class="cursor-pointer border border-yellow-200 bg-amarillo px-4 py-2 rounded-md font-semibold">
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
        })
    </script>
</div>
