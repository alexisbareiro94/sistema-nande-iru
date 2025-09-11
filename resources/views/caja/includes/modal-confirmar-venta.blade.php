<div id="modal-confirmar-venta"
    class="hidden fixed inset-0 bg-black/20 flex items-center justify-center z-40 transition-opacity duration-300">
    <div class="bg-white rounded-2xl w-full max-w-2xl overflow-hidden flex flex-col h-[100vh]">
        <!-- header -->
        <div class="bg-gradient-to-r from-gray-500 to-gray-600 p-4 flex justify-between items-center">
            <div class="flex space-x-20 items-center text-center object-center">
                <h2 class="text-white text-2xl font-bold flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Confirmar Venta
                </h2>

                <span class="flex gap-2 font-semibold text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                    {{ auth()->user()->name }}
                </span>

            </div>
            <!-- cerrar modal x -->
            <button id="cerrar-m-confirmar-ventas"
                class="text-white cursor-pointer hover:bg-gray-700 rounded-full p-2 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <!-- /header -->

        <div class="px-7 ">
            <!-- datos del cliente -->
            <div id="datos-cliente"
                class="flex flex-col mt-4 py-4 px-2 border border-gray-200 bg-gray-100 rounded-md shadow-md">
                <div class="flex text-center items-center gap-2 mb-4 mx-auto">                    
                    <h3 class="font-semibold text-lg text-center">
                        Datos del cliente
                    </h3>
                </div>
                <div class="px-4 gap-4 columns-2">
                    <div class="p-2 flex gap-2">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>

                        </span>
                        <p class="font-semibold">Razon Social: <span id="razon-venta" class="font-normal"></span> </p>
                    </div>
                    <div class="p-2 flex gap-2">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z" />
                            </svg>
                        </span>
                        <p class="font-semibold">RUC o CI: <span id="ruc-venta" class="font-normal"></span> </p>
                    </div>
                </div>
            </div>
            <!-- /datos del cliente -->

            <!-- metodo de pago -->
            <div id="" class="py-4 shadow-md rounded-md mt-4 bg-gray-100 border border-gray-200 ">
                <h3 class="mb-4 font-semibold text-gray-900 text-lg text-center">Seleccionar método de pago</h3>
                <p id="no-radio" class="hidden text-center mb-4 text-red-500 font-semibold px-2 bg-red-100 mx-auto max-w-[300px] rounded-md">Debes seleccionar un método de pago</p>
                <ul id="ul-pagos"
                    class="items-center w-full p-2 text-sm font-medium text-gray-900 bg-gray-100 border border-gray-200 sm:flex">
                    <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r">
                        <div class="flex items-center ps-3">
                            <input id="efectivo" type="radio" value="" name="list-radio"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                            <label for="efectivo" class="cursor-pointer w-full py-3 ms-2 text-sm font-medium text-gray-900">
                                Efectivo
                            </label>
                            <span class="mr-5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                                </svg>

                            </span>
                        </div>
                    </li>
                    <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r">
                        <div class="flex items-center ps-3">
                            <input id="transf" type="radio" value="" name="list-radio"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                            <label for="transf" class="cursor-pointer w-full py-3 ms-2 text-sm font-medium text-gray-900">
                                Transferencia
                            </label>
                            <span class="mr-5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M7.5 21 3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
                                </svg>
                            </span>
                        </div>
                    </li>
                    <li class="w-full border-b border-gray-200 sm:border-b-0">
                        <div class="flex items-center ps-3">
                            <input id="mixto" type="radio" value="" name="list-radio"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                            <label for="mixto" class="cursor-pointer w-full py-3 ms-2 text-sm font-medium text-gray-900">
                                Mixto
                            </label>
                            <span class="mr-5 flex">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                                </svg>
                                /
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M7.5 21 3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
                                </svg>
                            </span>
                        </div>
                    </li>
                </ul>

                <!-- monto recibido -->
                <form id="form-monto-recibido" action="">
                    <div id="monto-recibido" class="flex flex-col object-center text-center gap-2 px-10 py-4 ">
                        <div class="flex">
                            <label for="monto-recibido" class="text-gray-800 font-semibold mt-1 pr-12">Monto
                                Recibido:
                            </label>
                            <input class="border border-gray-300 px-3 py-1 rounded-md" type="number"
                                name="monto-recibido" id="i-monto-recibido">
                        </div>
                    </div>
                </form>                
                <!-- /monto recibido -->
            </div>
            <!-- /metodo de pago -->

            <!-- resumen del carrito -->
            <div class="mt-4 border border-gray-200 bg-gray-100 shadow-md rounded-md">
                <h3 class="text-lg font-semibold p-4 border-b border-gray-200 text-center">Productos y Servicios</h3>
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 ">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-200 ">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Producto
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Cant.
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Precio
                                </th>
                            </tr>
                        </thead>
                        <tbody id="body-tabla-venta">
                            <!-- -->
                        </tbody>
                        <tfoot id="footer-tabla-venta">
                            <!-- -->
                        </tfoot>
                    </table>
                </div>

            </div>
            <!-- /resumen del carrito -->
        </div>

        <!-- botones -->
        <div class="mt-auto font-semibold border-t border-gray-200 p-4 flex justify-end gap-3 bg-gray-50">
            <button id="cancelar-venta"
                class="px-4 py-2 bg-gray-300 text-gray-800 rounded-xl hover:bg-gray-400 transition-colors">
                Cancelar
            </button>
            <button id="confirmar-venta"
                class="cursor-pointer px-4 py-2 bg-green-500 text-white font-semibold rounded-xl hover:bg-green-600 transition-colors">
                Confirmar
            </button>
        </div>
        <!-- /botones -->

    </div>
</div>

<script>
    document.getElementById('cerrar-m-confirmar-ventas').addEventListener('click', () => {
        document.getElementById('modal-confirmar-venta').classList.add('hidden')
    })
</script>
