<div id="modalUsuarios" class="hidden fixed inset-0 bg-black/10 flex items-start justify-center z-50 transition-opacity duration-300">
    <div class="bg-white rounded-lg w-96 max-h-[80vh] overflow-y-auto shadow-lg p-4 mt-40 ml-10">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold">Usuarios</h2>
            <button id="cerrarModal" class="text-gray-500 hover:text-gray-700 text-xl cursor-pointer">&times;</button>
        </div>

        <!-- Lista de usuarios -->
        <ul id="listaUsuarios" class="space-y-2">
            <li>
                <button class="w-full text-left px-3 py-2 hover:bg-yellow-100 rounded" data-id="${user.id}">
                        alexis
                </button>
            </li>
            <li>
                <button class="w-full text-left px-3 py-2 hover:bg-yellow-100 rounded" data-id="${user.id}">
                        liz
                </button>
            </li>
        </ul>
    </div>

    <script>
        document.getElementById('cerrarModal').addEventListener('click', () => {
            document.getElementById('modalUsuarios').classList.add('hidden')
        })
    </script>
</div>