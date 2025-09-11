<tr class="hover:bg-gray-50 transition-colors">
    <td class="venta-id px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 items-center">
        <div class="flex items-center gap-2 mb-1">
            <span @class([
                'px-2 py-0.5 text-xs font-semibold rounded-xl', 
                'bg-green-200 text-green-800' => $venta->tipo === 'ingreso',
                'bg-red-200 text-red-800' => $venta->tipo === 'egreso',
                ]) >
                {{ ucfirst($venta->tipo) }}                
            </span>
            
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        {{ format_time($venta->created_at) }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
        <span class="bg-gray-200 text-gray-500 font-semibold px-2 py-0.5 rounded-xl italic" > Sin Cliente </span>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        {{ $venta->concepto }}
    </td>
    {{-- <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"> --}}
    <td @class([
        'px-6 py-4 whitespace-nowrap text-sm font-medium', 
        'text-gray-900' => $venta->tipo === 'ingreso',
        'text-red-500' => $venta->tipo === 'egreso',
        ]) >        
        {{ $venta->tipo === 'egreso' ? '-' : '' }}  Gs.{{ number_format($venta->monto, 0, ',', '.') }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
        <div class="flex space-x-2">
            <button id="btn-detalle-movimiento" data-ventaM="{{ $venta->id }}"
                class="detalle-movimiento cursor-pointer text-blue-600 hover:text-blue-900" title="Ver detalles">
                <i class="fas fa-eye">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                        <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                        <path fill-rule="evenodd"
                            d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                            clip-rule="evenodd" />
                    </svg>
                </i>
            </button>
            <button class="text-green-600 cursor-pointer hover:text-green-900" title="Imprimir">
                <i class="fas fa-print">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path fill-rule="evenodd"
                            d="M7.875 1.5C6.839 1.5 6 2.34 6 3.375v2.99c-.426.053-.851.11-1.274.174-1.454.218-2.476 1.483-2.476 2.917v6.294a3 3 0 0 0 3 3h.27l-.155 1.705A1.875 1.875 0 0 0 7.232 22.5h9.536a1.875 1.875 0 0 0 1.867-2.045l-.155-1.705h.27a3 3 0 0 0 3-3V9.456c0-1.434-1.022-2.7-2.476-2.917A48.716 48.716 0 0 0 18 6.366V3.375c0-1.036-.84-1.875-1.875-1.875h-8.25ZM16.5 6.205v-2.83A.375.375 0 0 0 16.125 3h-8.25a.375.375 0 0 0-.375.375v2.83a49.353 49.353 0 0 1 9 0Zm-.217 8.265c.178.018.317.16.333.337l.526 5.784a.375.375 0 0 1-.374.409H7.232a.375.375 0 0 1-.374-.409l.526-5.784a.373.373 0 0 1 .333-.337 41.741 41.741 0 0 1 8.566 0Zm.967-3.97a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H18a.75.75 0 0 1-.75-.75V10.5ZM15 9.75a.75.75 0 0 0-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 0 0 .75-.75V10.5a.75.75 0 0 0-.75-.75H15Z"
                            clip-rule="evenodd" />
                    </svg>
                </i>
            </button>
            <button class="text-red-600 hover:text-red-900 cursor-pointer" title="Eliminar">
                <i class="fas fa-trash">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                        <path fill-rule="evenodd"
                            d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z"
                            clip-rule="evenodd" />
                    </svg>
                </i>
            </button>
        </div>
    </td>
</tr>
