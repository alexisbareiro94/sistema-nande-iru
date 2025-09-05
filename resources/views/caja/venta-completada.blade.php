<div id="modal-venta-completada"
    class="hidden fixed inset-0 backdrop-blur-sm bg-black/10 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl shadow-lg max-w-lg w-full p-6 space-y-5">

        <div class="flex justify-between items-center border-b pb-3">
            <h2 class="text-xl font-bold text-gray-800">Venta completada</h2>
            <button id="btnCerrar"
                class="cursor-pointer text-gray-500 hover:text-gray-800 text-2xl leading-none">&times;</button>
        </div>

        <div class="text-center">
            <svg class="w-14 h-14 mx-auto text-green-500 mb-3" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 12l2 2l4 -4m6 2a9 9 0 11-18 0a9 9 0 0118 0z" />
            </svg>
            <p class="text-gray-600">La venta se registró correctamente.</p>
        </div>

        <h3 class="font-semibold text-gray-800 underline text-center">Resumen:</h3>
        <div id="resumen-venta" class="bg-gray-50 rounded-xl p-4 text-sm text-gray-700 space-y-2">
            <ul class="space-y-1">
                <li><strong>Código de Venta:</strong> 001</li>
                <li>
                    <strong>Cliente:</strong>
                    <ul class="ml-4 list-disc list-inside">
                        <li>Razón social: Alexis Bareiro</li>
                        <li>RUC o CI: 5345343</li>
                    </ul>
                </li>
                <li>
                    <strong>Productos:</strong>
                    <ul class="ml-4 list-disc list-inside">
                        <li>Producto A</li>
                        <li>Producto B</li>
                    </ul>
                </li>
                <li><strong>Subtotal:</strong> 102.000 Gs</li>
                <li class="font-bold text-gray-900"><strong>Total:</strong> 102.000 Gs</li>
            </ul>
        </div>

        <!-- Botones de acción -->
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="#"
                class="flex items-center justify-center gap-2 bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-xl shadow transition">
                🧾 Imprimir Ticket
            </a>
            <a href="#"
                class="flex items-center justify-center gap-2 bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-xl shadow transition">
                📄 Imprimir Factura
            </a>
            <button id="btnSalir"
                class="cursor-pointer flex items-center justify-center gap-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-2 px-4 rounded-xl shadow transition">
                Salir
            </button>
        </div>
    </div>
</div>
<script>
    document.getElementById('btnCerrar').addEventListener('click', (e) => {
        e.target.closest('#modal-venta-completada').classList.add('hidden');
    })

    document.getElementById('btnSalir').addEventListener('click', (e) => {
        e.target.closest('#modal-venta-completada').classList.add('hidden');
    })
</script>
