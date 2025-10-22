<div id="modal-todos-clientes"
    class="hidden fixed inset-0 bg-black/20 backdrop-blur-xs flex items-center justify-center z-30 p-4">
    <div class="bg-white rounded-xl max-h-[90vh]  shadow-2xl p-3 space-y-6 ">

        <!-- Encabezado -->
        <div class=" flex justify-between items-center pb-2 border-b">
            <h2 class="text-xl font-bold text-gray-800">Lista completa de usuarios</h2>
            <button id="cerrar-modal-todos-cliente"
                class="cursor-pointer text-gray-400 hover:text-gray-600 text-2xl leading-none transition-colors">
                &times;
            </button>
        </div>


        <div class="relative  rounded-md bg-white px-2 mb-2 max-h-[80vh] overflow-y-scroll">
            <div class="bg-white p-1 font-semibold  flex justify-between mb-4">
                <h3 class="text-lg flex items-center">
                    
                    <!-- buscador -->
                    <div class="flex pl-3 items-center min-w-md mx-auto">
                        <label for="simple-search" class="sr-only">Search</label>
                        <div class="relative w-full">                            
                            <input type="text" id="todos-clientes-input"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-5 p-2.5"
                                placeholder="Buscar por nombre o numero de documento" required />
                        </div>
                        <button 
                            class="p-2.5 ms-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                            <span class="sr-only">Search</span>
                        </button>
                    </div>

                </h3>
            </div>

            <table class="w-full text-sm text-left rtl:text-right text-gray-500 ">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 ">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Cliente
                        </th>
                        <th scope="col" class="px-6 py-3">
                            RUC - CI
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Compras
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Registro
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody id="todos-clientes-table-body">
                    @foreach ($clientes as $cliente)
                        <tr data-id="{{ $cliente->id }}" class="tr-clientes bg-white border-b  border-gray-200">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $cliente->razon_social }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $cliente->ruc_ci }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $cliente->compras->count() }}
                            </td>
                            <td class="px-6 py-4">
                                {{ format_time($cliente->created_at) }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-5">
                                    <button
                                        class="edit-cliente-gcd hover:text-blue-500 cursor-pointer transition-all active:scale-90"
                                        data-id="{{ $cliente->id }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                    </button>

                                    <button
                                        class="borrar-cliente-gcd hover:text-red-500 cursor-pointer transition-all active:scale-90"
                                        data-id="{{ $cliente->id }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
