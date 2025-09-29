<div id="modal-movimiento-caja" class="hidden fixed inset-0 bg-black/20 flex items-center justify-center z-50 ">
    <div class="bg-gray-100 rounded-2xl shadow-xl w-full max-w-[500px] p-6 border border-gray-700 relative">

        <button id="closeModalM"
            class="absolute cursor-pointer top-3 right-3 text-gray-900 hover:text-gray-600 text-2xl">&times;</button>

        <h2 class="text-xl font-bold text-gray-800 mb-4 text-center">Movimiento</h2>

        <div class="flex items-center justify-center mb-4">
            <span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>

            </span>
            <span class="text-gray-900 text-sm">Usuario: </span>
            <span class="text-gray-800 font-semibold ml-2">{{ auth()->user()->name }}</span>
        </div>

        <form id="movimiento-form" action="#">
            <div class="mb-2 flex items-center">
                <span class="text-gray-700 mr-4 font-semibold">Tipo de movimiento:</span>

                <div class="flex bg-gray-100 rounded-lg p-1">
                    <label class="flex-1 cursor-pointer">
                        <input type="radio" name="tipo-movimiento" value="egreso" class="hidden peer" />
                        <div
                            class="px-4 py-2 text-sm font-medium rounded-md peer-checked:bg-red-400 peer-checked:shadow-sm transition-all text-gray-600 peer-checked:text-white">
                            Egreso
                        </div>
                    </label>

                    <label class="flex-1 cursor-pointer">
                        <input type="radio" name="tipo-movimiento" value="ingreso" class="hidden peer" />
                        <div
                            class="px-4 py-2 text-sm font-medium rounded-md peer-checked:bg-green-400 peer-checked:shadow-sm transition-all text-gray-600 peer-checked:text-white">
                            Ingreso
                        </div>
                    </label>

                    @if (Auth::user()->role == 'admin')
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="tipo-movimiento" value="salario" class="hidden peer" />
                            <div
                                class="px-4 py-2 text-xs font-medium rounded-md peer-checked:bg-yellow-400 peer-checked:shadow-sm transition-all text-gray-600 peer-checked:text-white">
                                Pago de salario
                            </div>
                        </label>
                    @endif
                </div>
            </div>

            <div id="salario-cont" class="mb-4 hidden">
                <div
                    class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 p-4 bg-gray-50 rounded-lg">
                    <select id="personales" name="personal"
                        class="px-3 py-2 border border-gray-400 text-gray-700 bg-white rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                        <option value="" disabled selected>Seleccionar Personal</option>
                        @foreach ($users as $user)
                            <option class="personal" value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>

                    <div id="datos-personal" class="hidden text-right text-gray-800 space-y-1">
                        <p class="font-medium">Alexis Bareiro</p>
                        <p class="text-sm"><span class="data-personal font-semibold">Salario:</span> 3.200.000</p>
                        <p class="text-sm"><span class="data-personal font-semibold">Restante:</span> 1.200.000</p>
                        <p class="text-sm"><span class="data-personal font-semibold">Adelanto:</span> 9-09</p>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <label for="concepto-mm" class="block font-semibold text-gray-900 text-sm mb-2">Concepto</label>
                <input type="text" id="concepto-mm" name="concepto-mm" placeholder="Ingrese el concepto"
                    class="w-full px-4 py-2 rounded-lg bg-gray-200 text-black border border-gray-700 focus:border-gray-800 focus:ring focus:ring-gray-800/30 outline-none">
            </div>

            <div class="mb-4">
                <label for="monto-mm" class="block text-gray-900 font-semibold text-sm mb-2">Monto</label>
                <input type="number" id="monto-mm" name="monto-mm" step="0.01" placeholder="100.000"
                    class="w-full px-4 py-2 rounded-lg bg-gray-200 text-black border border-gray-700 focus:border-gray-800 focus:ring focus:ring-gray-800/30 outline-none">
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" id="cancelarModalM"
                    class="cursor-pointer px-4 py-2 rounded-lg bg-gray-200 text-gray-800 font-bold hover:bg-gray-300">
                    Cancelar
                </button>
                <button type="submit" id="confirmar-movimiento"
                    class="cursor-pointer px-4 py-2 rounded-lg bg-gray-800 text-gray-100 font-bold hover:bg-gray-700">
                    Confirmar
                </button>
            </div>
        </form>
    </div>
</div>


<script>
    const btns = document.querySelectorAll('#closeModalM, #cancelarModalM');
    btns.forEach((btn) => {
        btn.addEventListener('click', () => {
            document.getElementById('modal-movimiento-caja').classList.add('hidden');
        });
    }, {
        once: true
    })
</script>
