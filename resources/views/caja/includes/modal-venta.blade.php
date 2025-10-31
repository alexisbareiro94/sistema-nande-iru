<div @class([
        'fixed inset-0 backdrop-blur-xs bg-black/20 flex items-center justify-center z-40 transition-opacity duration-300', 
        'hidden' => Auth::user()->role == 'admin',
        'hidden' => !session('caja')
    ]) 
    id="modal-ventas">
    <div class="bg-white border-1 border-gray-800 rounded-2xl w-full max-w-[80%] shadow-2xl overflow-hidden flex flex-col h-[90vh]">
        <!-- Header con título y botón de cierre -->
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-700 p-4 flex justify-between items-center">
            <div class="flex space-x-20 items-center text-center object-center">
                <h2 class="text-gray-800 text-2xl font-bold flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Nueva Venta
                </h2>

                <span class="flex gap-2 font-semibold text-gray-800">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                    {{ auth()->user()->name }}
                </span>

            </div>
            <!-- cerrar modal x -->
            <button id="cerrar-modal-ventas"
                class="text-gray-800 cursor-pointer hover:bg-gray-200 rounded-full p-2 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="flex flex-1 overflow-hidden">
            <!-- Izquierda: Lista de productos -->
            <div class="w-2/3 p-3 flex flex-col">
                <!-- Buscador con icono -->
                <div class="relative mb-5">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <form id="form-b-productos-ventas">
                        <input id="input-b-producto-ventas" type="text"
                            placeholder="Buscar producto por nombre, código o categoría..."
                            class="w-full pl-12 pr-4 py-3 border border-gray-300  rounded-xl focus:ring-2 focus:ring-gray-400 focus:border-gray-400 transition-all">
                    </form>
                </div>

                <!-- Tabla de productos con mejor diseño -->
                <div class="overflow-y-auto rounded-xl border border-gray-200 shadow-sm flex-1">
                    <table class="w-full text-left">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100 sticky top-0 z-10">
                            <tr class="text-gray-800">
                                <th class="px-5 py-3 font-semibold">Producto</th>
                                <th class="px-5 py-3 font-semibold">Precio</th>
                                <th class="px-5 py-3 font-semibold">Stock</th>
                                <th class="px-5 py-3 font-semibold text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody id="tabla-venta-productos" class="divide-y divide-gray-100">
                            {{-- aca se renderizan los productos --}}
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Derecha: Carrito de venta -->
            <div class="w-1/3 p-2 flex flex-col gap-1 bg-gray-50 relative">
                @include('caja.includes.modal-usuarios')
                <!-- Información del cliente -->
                <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-200">
                    <h3 class="font-bold text-lg text-gray-700 mb-3 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Cliente
                    </h3>

                    <div class="space-y-3">
                        <form id="form-cliente-venta" action="">
                            <div class="mb-1">
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    RUC o CI <span id="ob" class="text-red-500 text-lg">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 21h7a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H5a2 2 0 00-2 2v11a2 2 0 00.293 1.207l5.414 5.414A1 1 0 009.414 21z" />
                                        </svg>
                                    </div>
                                    <input id="i-ruc-ci" type="string" placeholder="Ingrese RUC o CI" value=""
                                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-400 focus:border-gray-400">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Nombre o Razón Social <span class="text-red-500 text-lg">*</span> 
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <input id="i-nombre-razon" type="text"
                                        placeholder="Ingrese nombre o razón social" value=""
                                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-400 focus:border-gray-400">
                                </div>
                            </div>
                            <button class="sr-only" type="submit">b</button>
                        </form>
                    </div>
                </div>

                <!-- Carrito de compras -->
                <div
                    class="bg-white rounded-xl p-4 shadow-sm border border-gray-200 flex-1 flex flex-col overflow-y-auto">
                    <div class="flex justify-between items-center mb-3">
                        <h4 class="font-bold text-gray-700 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Carrito
                        </h4>
                        <button id="limpiar-carrito"
                            class="cursor-pointer text-sm text-gray-600 hover:text-gray-800 font-medium flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Limpiar
                        </button>
                    </div>


                    <div id="carrito" class="flex-1 overflow-y-auto  space-y-1 ">
                        <form action="" id="carrito-form">
                            <!-- aca se muestran los productos seleccionados -->
                        </form>
                    </div>

                    <div class="border-t pt-4 mt-2">
                        <div class="flex justify-between items-center text-lg font-bold">
                            <span class="text-gray-600">SUBTOTAL:</span>
                            <span id="subTotalCarrito"
                                class="text-gray-700 text-xl"><!-- subtotal del carrito --></span>
                        </div>
                        <div class="flex justify-between items-center text-lg font-bold">
                            <span class="text-gray-600">TOTAL:</span>
                            <span id="totalCarrito" class="text-gray-600 text-2xl"><!-- total del carrito --></span>
                        </div>
                    </div>

                </div>

                <div class="flex gap-3 pt-2">
                    <button id="cancelar-venta"
                        class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-3 rounded-xl transition-colors flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Cancelar
                    </button>
                    <button id="procesar-venta"
                        class="flex-1 bg-green-500 hover:bg-green-600 text-white font-bold py-3 rounded-xl transition-colors shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Procesar Venta
                    </button>
                </div>
            </div>
        </div>
        @include('caja.includes.modal-confirmar-venta')
    </div>

    <script>
        document.getElementById('cancelar-venta').addEventListener('click', () => {
            document.getElementById('modal-ventas').classList.add('hidden');
            sessionStorage.clear();
            renderCarrito();    
            document.getElementById('totalCarrito').innerHTML = ''
            document.getElementById('subTotalCarrito').innerHTML = ''
            document.getElementById('form-cliente-venta').reset();
        })


        document.getElementById('limpiar-carrito').addEventListener('click', () => {
            sessionStorage.clear();
            document.getElementById('totalCarrito').innerHTML = ''
            document.getElementById('subTotalCarrito').innerHTML = ''
            renderCarrito();    
        });
    </script>
</div>
