@extends('layouts.app')
@section('ruta-anterior', 'Reportes')
@section('url', '/reportes')
@section('titulo', 'Top Ventas')
@section('ruta-actual', 'Top Productos')

@section('contenido')
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-2 gap-4 p-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Productos mas vendidos</h2>
            <p class="text-gray-600 text-sm">Administra tu inventario de productos y servicios</p>
        </div>


    </div>
    <div class="lg:col-span-2 bg-white rounded-lg shadow p-6">

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
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
                        Ingresos Totales</th>
                    {{-- <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        % del Total de Ventas</th> --}}
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Stock
                    </th>
                    {{-- <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Tendencia
                    </th>                     --}}
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Última Venta
                    </th>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($productos as $producto)
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
                            {{-- class="px-4 py-4 whitespace-nowrap text-sm text-gray-500" --}}
                            <td @class([
                                'px-4 py-4 whitespace-nowrap text-sm font-semibold',
                                'text-blue-500' => $producto->tipo === 'producto',
                                'text-green-500' => $producto->tipo === 'servicio',
                            ])>
                                {{ $producto->tipo }}
                            </td>
                                                        
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $producto->ventas }}
                            </td>                            

                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                Gs. {{ moneda($producto->detalles->sum('total')) }}
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <span @class([
                                    'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                                    'bg-green-100 text-green-800' => $producto->stock > 5,
                                    'bg-yellow-100 text-yellow-800' => $producto->stock <= 5 && $producto->stock > 2,
                                    'bg-red-100 text-red-800' => $producto->stock <= 2,
                                ])>
                                    {{ $producto->stock }}
                                </span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 cursor-help"
                                title="{{ $producto->ultima_venta?->created_at->format('d-m-Y H:i') }}">
                                {{ $producto->ultima_venta?->created_at->diffForHumans() }}

                            </td> 
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
