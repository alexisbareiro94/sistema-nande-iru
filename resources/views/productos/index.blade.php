@extends('layouts.app')

@section('titulo', 'Inventario')

@section('ruta-actual', 'Inventario')

@section('contenido')    
        <!-- Encabezado -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4 p-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Productos</h2>
                <p class="text-gray-600 text-sm">Administra tu inventario de productos y servicios</p>
            </div>
            <a href="{{ route('producto.add') }}"
                class="flex items-center gap-2 cursor-pointer text-lg bg-gray-800 hover:bg-gray-800 text-gray-200 px-4 py-2 font-semibold rounded-lg shadow transition text-center whitespace-nowrap">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>

                </span>
                Nuevo Producto
            </a>
        </div>

        <!-- Estadísticas -->
        @include('productos.includes.estadisticas')

        <div class="overflow-x-auto bg-white shadow rounded-xl">
            <!-- Barra de Búsqueda -->
            <div class=" justify-center object-center items-center mb-6 mt-6 gap-2 grid grid-cols-8 px-4">
                <p class="col-span-2 text-left font-semibold text-xl">
                    Lista de productos
                </p>
                <div class="relative col-span-4">
                    <form id="form-inventario" action="" method="get" class="flex">
                        <!-- Icono de búsqueda -->
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                        </div>

                        <input id="i-s-inventario" type="text" placeholder="Buscar productos..."
                            class="w-full pl-12 pr-40 py-2.5 border border-gray-800 bg-white/20 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-gray-800 focus:border-transparent transition-all duration-200" />

                        <button id="btn-cerrar-inv"
                            class="hidden cursor-pointer absolute z-20 inset-y-0 right-40 rounded-lg px-1 transition-all duration-200 hover:bg-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>

                        <select
                            class="w-auto px-4 py-2.5 bg-gray-800 border-l border-gray-800 text-white font-medium rounded-r-lg focus:outline-none focus:ring-2 focus:ring-gray-800 cursor-pointer"
                            name="filtro" id="filtro">
                            <option value="">Buscar por</option>
                            <option value="nombre">Nombre</option>
                            <option value="tipo">Tipo Producto</option>
                            <option value="categoría">Categorías</option>
                            <option value="marca">Marcas</option>
                        </select>
                    </form>
                </div>
                
            </div>
            <!-- Tabla de Productos -->
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-white border-t border-gray-200">
                    <tr>
                        <th class="pl-6 py-3 text-left text-sm font-semibold text-gray-900 uppercase flex gap-1">
                            Nombre
                            @include('productos.icons.nombres')
                        </th>
                        <th class="px-2 py-3 text-left text-sm font-semibold text-gray-900 uppercase">Código</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 uppercase flex gap-1">
                            Precio
                            @include('productos.icons.precio')
                        </th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 uppercase">
                            <div class="flex">
                                Stock
                                @include('productos.icons.stock')
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 uppercase">Distribuidor</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody id="body-table-inv" class="divide-y divide-gray-200">
                    @foreach ($productos as $producto)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="pl-3 py-3 text-sm">
                                <p class="font-semibold">{{ $producto->nombre ?? '' }}</p>
                                <p class="text-gray-500 text-xs">{{ $producto->marca->nombre ?? '' }}</p>
                            </td>
                            <td class="px-2 py-3 text-sm">{{ $producto->codigo ?? '' }}</td>
                            <td class="pl-3 py-3 text-sm font-medium">
                                GS. {{ number_format($producto->precio_venta, 0, ',', '.') }}
                            </td>
                            <td @class([
                                'pl-3 py-3 text-sm',
                                'text-gray-400 italic' => $producto->tipo == 'servicio',
                                'text-orange-600 font-bold bg-orange-100' =>
                                    $producto->stock_minimo >= $producto->stock &&
                                    $producto->stock >= 1 &&
                                    $producto->tipo == 'producto',
                                'font-bold bg-red-200 text-red-700' => $producto->stock === 0,
                            ])>
                                <span @class([
                                    'font-semibold rounded-full',
                                    'text-green-400 text-center bg-green-100 px-2 py-1' =>
                                        $producto->tipo === 'servicio',
                                ])>
                                    {{ $producto->tipo === 'servicio' ? 'Servicio' : $producto->stock }}
                                </span>

                                <span @class(['ml-2 text-xs', 'text-red-700' => $producto->stock === 0])>
                                    @if ($producto->tipo === 'producto' && $producto->stock == 0)
                                        sin stock
                                    @elseif($producto->tipo == 'producto' && $producto->stock_minimo >= $producto->stock)
                                        stock min.
                                    @endif
                                </span>
                            </td>
                            <td @class([
                                'pl-3 py-3 text-sm',
                                'text-gray-400 italic' => $producto->tipo == 'servicio',
                            ])>
                                {{ $producto->tipo == 'servicio' ? 'Servicio' : $producto->distribuidor->nombre ?? '' }}
                            </td>
                            <!-- botones -->
                            <td class="pl-3 py-3 text-sm flex items-center space-x-3">
                                <a href="{{ route('producto.update.view', ['id' => $producto->id]) }}"
                                    class="edit-product text-blue-600 hover:text-blue-800 transition-colors"
                                    title="Editar producto">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </a>
                                <button data-producto="{{ $producto->id }}"
                                    class="cursor-pointer delete-producto text-red-600 hover:text-red-800 transition-colors"
                                    title="Eliminar producto">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div id="links" class=" px-4  py-2 text-gray-900">
                {{ $productos->links() }}
            </div>
        </div>

        <!-- Modal Eliminar -->
        @include('productos.includes.modal-delete')        

@endsection
