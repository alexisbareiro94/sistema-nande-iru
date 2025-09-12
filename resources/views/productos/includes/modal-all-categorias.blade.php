<div id="cont-ver-categorias" class="hidden flex inset-0 fixed z-50 justify-center items-center w-full h-full bg-black/40">
    <div class="relative p-4 w-full max-w-lg max-h-[90vh] overflow-y-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-sm">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 border-b rounded-t border-gray-200">
                <h3 class="text-xl font-semibold text-gray-900">
                    Categorias
                </h3>

                <div class="pl-10 flex relative">
                    <form action="" method="get">
                        <input id="query-c" type="text" name="query-c" placeholder="Buscar categoria..."
                               class="border border-gray-300 rounded-l-lg px-2 py-2">
                    </form>
                    <button type="submit" id="s-query-c" class="px-2 py-1 bg-gray-800 rounded-r-lg text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </button>
                    {{--boton para volver a mostrar todas las marcas--}}
                    <button id="cerrar-q-c" class="hidden absolute z-50 right-10 top-1 mr-1 text-gray-400 px-1 py-1 transition-all duration-150 hover:bg-gray-300 hover:text-gray-700 rounded-md cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>

                </div>

                <button id="cerrar-ver-categoria" type="button"
                        class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
                    <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>

            <!-- Modal body -->
            <div class="p-4 md:p-5 max-h-[70vh] overflow-y-auto">
                <div id="tabla-categorias">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th class="px-6 py-3">Nombre</th>
                            <th class="px-6 py-3">Acciones</th>
                        </tr>
                        </thead>
                        <tbody id="body-tabla-categorias">
                        @foreach ($categorias as $categoria)
                            @if ($categoria->id == 1) @continue @endif
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $categoria->nombre }}
                                </th>
                                </td>
                                <td class="px-6 py-4">
                                    <button type="button"
                                            class="font-medium text-red-600 hover:underline px-2 py-1 rounded-lg hover:scale-110 duration-150 hover:bg-red-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

