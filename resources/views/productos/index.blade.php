@extends('layouts.app')

@section('titulo', 'inventario')

@section('contenido')
    <div class="mx-6 mt-8">
        <!-- Título -->
        <h2 class="text-2xl font-bold text-center text-negro mb-6">Productos</h2>

        <!-- Botones -->
        <div class="flex flex-wrap justify-center gap-4 mb-6">
            <a href="{{ route('producto.add') }}"
                class="cursor-pointer bg-amarillo text-negro px-6 py-2 font-semibold rounded-lg shadow hover:opacity-90 transition">
                Agregar Producto
            </a>
            <a
                class="cursor-pointer bg-rojo text-white px-6 py-2 font-semibold rounded-lg shadow hover:opacity-90 transition">
                Agregar Distribuidor
            </a>
        </div>

        <!-- Barra de búsqueda -->
        <div class="flex justify-center mb-6 gap-2">
            <div class="relative w-full max-w-lg">
                <form id="form-inventario" action="" method="get">
                    <!-- Input de búsqueda con ícono dentro -->
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </div>

                    <!-- barra de busqueda -->
                    <input id="i-s-inventario" type="text" placeholder="Buscar productos..."
                        class="w-full pl-12 pr-4 py-2.5 border border-amarillo bg-white/20 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition-all duration-200" />

                    <button id="btn-cerrar-inv"
                        class="hidden cursor-pointer absolute z-20 inset-y-0 right-40 rounded-lg  px-1 transition-all duration-200 hover:bg-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <select
                        class="absolute inset-y-0 right-0 w-auto px-4 py-2.5 bg-amber-400 border-l border-amber-500 text-white font-medium rounded-r-lg focus:outline-none focus:ring-2 focus:ring-amber-300 cursor-pointer"
                        name="" id="filtro">
                        <option value="">Buscar por</option>
                        <option value="nombre">Nombre</option>
                        <option value="tipo">Tipo Producto</option>
                        <option value="categoría">Categorias</option>
                        <option value="marca">Marcas</option>
                    </select>
                </form>
            </div>
        </div>

        <!-- Tabla de productos -->
        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-amarillo">
                    <tr>
                        <th class="pl-6 py-3 text-left text-sm font-semibold text-negro uppercase">Nombre</th>
                        <th class="px-2 py-3 text-left text-sm font-semibold text-negro uppercase">Código</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-negro uppercase">Precio</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-negro uppercase">Stock</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-negro uppercase">Distribuidor</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-negro uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody id="body-table-inv" class="divide-y divide-gray-200">
                    @foreach ($productos as $producto)
                        <tr>
                            <td class="pl-6 py-4 text-sm">
                                <p class="font-semibold">{{ $producto->nombre }}</p>
                                <p class="text-gray-500">{{ $producto->marca->nombre ?? '' }}</p>
                            </td>
                            <td class="px-2 py-4 text-sm">{{ $producto->codigo }}</td>
                            <td class="px-6 py-4 text-sm">
                                GS. {{ number_format($producto->precio_venta, -2, ',', '.') }}
                            </td>
                            <td @class([
                                'px-6 py-4 text-sm',
                                'text-gray-300 font-semibold' => $producto->tipo == 'servicio',
                                'text-red-500 font-bold' =>
                                    $producto->stock_minimo >= $producto->stock &&
                                    $producto->tipo == 'producto',
                            ])>
                                {{ $producto->tipo == 'servicio' ? 'Servicio' : $producto->stock }}
                                @if ($producto->stock_minimo >= $producto->stock && $producto->tipo == 'producto')
                                    <a class="text-xs font-light px-2 bg-red-100">stock mínimo</a>
                                @endif
                            </td>
                            <td @class([
                                'px-6 py-4 text-sm',
                                'text-gray-300 font-semibold' => $producto->tipo == 'servicio',
                                //'text-green-500' => $producto->stock_minimo >= $producto->stock,
                            ])>

                                {{ $producto->tipo == 'servicio' ? 'Servicio' : $producto->distribuidor->nombre }}</td>
                            <td class="px-6 py-4 text-sm flex">
                                <a href="{{ route('producto.update.view', ['id' => $producto->id]) }}"
                                    class="edit-product text-blue-600 hover:underline text-sm cursor-pointer transition-all duration-150 hover:bg-blue-100 px-1 py-1 rounded-md"
                                    data-edit="{{ $producto->id }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </a>
                                <button data-producto="{{ $producto->id }}"
                                    class="delete-producto text-red-600 hover:underline ml-4 text-sm cursor-pointer transition-all duration-150 hover:bg-red-100 px-1 py-1 rounded-md">
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
    @include('productos.includes.modal-delete')
@endsection
