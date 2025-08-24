<div id="delete-container"
    class="hidden fixed inset-0 bg-black/50 z-50 top-0 flex justify-center items-center overflow-y-auto overflow-x-hidden">
    <div  class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm">
            <div id="sec-delete-container" class="p-4 md:p-5 text-center">
                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <h3 id="product-h3" class="mb-5 text-lg font-normal text-gray-500">
{{--                    ¿Estás seguro de eliminar este producto?--}}
                </h3>

                <div class="flex gap-3 justify-center">
                    <button id="cancelar-d"
                        class="text-gray-500 bg-gray-200 hover:bg-gray-300 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5">
                        No, cancelar
                    </button>
                    <button id="confirmar-d"
                        class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5">
                        Sí, eliminar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

