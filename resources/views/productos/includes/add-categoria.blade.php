<div id="cont-add-categoria" class=" hidden overflow-y-auto flex inset-0 fixed z-50 justify-center items-center w-full h-[calc(100%-1rem)] max-h-full bg-black/40">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class=" bg-white rounded-lg shadow-sm">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
                <h3 class="text-xl font-semibold text-gray-900">
                    Agregar Categoria
                </h3>
                <button id="cerrar-categoria" type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="authentication-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Cerrar modal</span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="p-4 md:p-5">
                <form id="form-categoria" class="space-y-4" action="#" method="POST">
                    <div>
                        <label for="categoria_nombre" class="block mb-2 text-sm font-medium text-gray-900">Nueva Categoria</label>
                        <input type="text" name="categoria_nombre" id="categoria_nombre" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"  required />
                    </div>

                    <button id="btn-add-categoria" type="button"
                            class="mb-2 w-full cursor-pointer text-white bg-gray-700 hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        Agregar
                    </button>

                    <button id="all-categorias" type="button" class="w-full cursor-pointer text-black bg-white border border-white hover:border-gray-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        Todas las Categorias
                    </button>
                </form>
            </div>
        </div>
    </div>
    @include('productos.includes.modal-all-categorias')
</div>
