@extends('layouts.app')
@section('titulo', 'Reportes')
@section('ruta-actual', 'Reportes')

@section('contenido')
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-2 gap-4 p-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Reportes</h2>
            <p class="text-gray-600 text-sm">Administra tu inventario de productos y servicios</p>
        </div>

        <div class="flex items-center gap-2  text-lg bg-gray-100 border border-gray-200 shadow-md text-gray-800 px-4 py-2 font-semibold rounded-lg">
            {{ \Carbon\Carbon::parse(now())->format('d / m / Y') }}
        </div>
    </div>
    <div class="flex">
        <div class="flex-1 flex flex-col">
            <main class="flex-1 p-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                    @include('reportes.includes.header')
                </div>

                <!-- Gráficos -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                    <!-- Evolución de ventas -->
                    @include('reportes.includes.evolucion-ventas')
                    
                    <div class="bg-white rounded-lg shadow p-6 flex-col">
                        <!-- grafico de formas de pago -->
                        @include('reportes.includes.tipo-forma-de-pago')
                    </div>
                </div>

                <!-- graficos de utilidades -->
                <div class="bg-white rounded-lg shadow p-6 min-h-20">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Reportes de Utilidad por Rango de Fechas</h3>
                        <!-- Contenedor de botones -->
                        @include('reportes.includes.btns-utilidades')
                    </div>

                    <!-- Contenedor de métricas -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <!-- Ganancia Actual -->
                        @include('reportes.includes.card-ganancias')

                        @include('reportes.includes.grafico-tendencias')
                    </div>
                </div>

                <!-- egresos -->
                <div class="grid grid-cols-3 gap-6">
                    <!-- evolucion de egresos-->
                   @include('reportes.includes.graficos-egresos')
                </div>

                <!-- Productos más vendidos y Alertas -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                    <!-- Top productos -->
                   @include('reportes.includes.top-productos')

                    <!-- Alertas -->
                    @include('reportes.includes.alertas')
                </div>

                <!-- Reportes -->
                <div class="bg-white rounded-lg shadow p-6">
                    @include('reportes.includes.reportes')
                </div>
            </main>
        </div>
    </div>
    @include('reportes.modal-todas-notificaciones')
@endsection
