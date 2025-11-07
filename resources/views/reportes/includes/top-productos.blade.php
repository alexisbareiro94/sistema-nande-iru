<div class="lg:col-span-2 bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-700">Productos Más Vendidos</h3>
        <a href="{{ route('producto.top.ventas') }}" class="text-primary text-sm flex font-semibold items-center group">
            Ver todos
            <i class="ml-2 items-center">
                <svg class="w-5 transition-all duration-150 group-hover:translate-x-1" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                </svg>
            </i>
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Producto
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Categoría
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Ventas
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Stock
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @if ($data)

                    @foreach ($data['productos_vendidos'] as $producto)
                        <tr>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-gray-200 rounded-md"></div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $producto->nombre }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $producto->tipo }}
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $producto->ventas }}
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                {{-- class=" bg-green-100 text-green-800" --}}
                                <span @class([
                                    'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                                    'bg-green-100 text-green-800' => $producto->stock > 5,
                                    'bg-yellow-100 text-yellow-800' =>
                                        $producto->stock <= 5 && $producto->stock > 2,
                                    'bg-red-100 text-red-800' => $producto->stock < 2,
                                ])>
                                    {{ $producto->stock }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
