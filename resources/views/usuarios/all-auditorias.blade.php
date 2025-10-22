@extends('layouts.app')

@section('ruta-actual', 'Auditorias')
@section('ruta-anterior', 'Gestión de usuarios')
@section('url', '/gestion_usuarios')

@section('contenido')
    <header class="flex flex-col md:flex-row md:items-center mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Todas las acciones</h2>
        </div>
    </header>
    <div class="lg:col-span-2 bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-700"></h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class=>
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Creado por
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tipo
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Datos
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Fecha
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($auditorias as $auditoria)
                        <tr>
                            <td class="px-4 py-3 text-gray-700">{{ $auditoria->user->name ?? '' }}</td>
                            <td class="px-4 py-3 text-gray-700">{{ $auditoria->accion }}</td>
                            <td class="px-4 py-3 text-gray-700">
                                @if ($auditoria->datos)
                                    @foreach ($auditoria->datos as $key => $dato)
                                        {{ $key }}: {{ is_numeric($dato) ? moneda($dato) : $dato }}
                                        <br>
                                    @endforeach
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-700">{{ format_time($auditoria->created_at) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $auditorias->links() }}
    </div>

@endsection
