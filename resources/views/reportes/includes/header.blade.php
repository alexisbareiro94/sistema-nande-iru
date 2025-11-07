<!-- Ventas totales -->
<div class="bg-white rounded-lg shadow p-6">
    @if (session('caja'))
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-primary">
                <i class="fas fa-shopping-cart text-xl"></i>
            </div>
            <div class="mx-4">
                <h4 class="text-gray-500 text-sm">Ventas de Este Mes</h4>
                <div class="text-2xl font-bold">Gs.
                    {{ number_format($data['ventas_hoy']['saldo'] ?? 0, 0, ',', '.') }}</div>
            </div>
        </div>
        <div class="mt-4 text-green-500 text-sm flex items-center">
            <i class="fas fa-arrow-up mr-1"></i>
            <span>{{ $data['ventas_hoy']['tag'] ?? 0 }}{{ $data['ventas_hoy']['porcentaje'] ?? 0 }}% respecto
                hasta mismo dia del mes pasado</span>
        </div>
    @else
        <div class="text-center py-8">
            <span class="text-gray-500 font-medium">No hay ninguna caja abierta</span>
        </div>
    @endif
</div>

<!-- Clientes nuevos -->
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex items-center">
        <div class="p-3 rounded-full bg-green-100 text-accent">
            <i class="fas fa-user-plus text-xl"></i>
        </div>
        <div class="mx-4">
            <h4 class="text-gray-500 text-sm">Clientes nuevos</h4>
            <div class="text-2xl font-bold">{{ $data['clientes_nuevos']['nuevos'] ?? 0}}</div>
        </div>
    </div>
    <div class="mt-4 text-green-500 text-sm flex items-center">
        <i class="fas fa-arrow-up mr-1"></i>
        <span>{{ $data['clientes_nuevos']['tag'] ?? 0 }}{{ $data['clientes_nuevos']['porcentaje'] ?? 0}}%
            respecto al mes pasado</span>
    </div>
</div>

<!-- Productos más vendidos -->
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex items-center">
        <div class="p-3 rounded-full bg-purple-100 text-purple-500">
            <i class="fas fa-box-open text-xl"></i>
        </div>
        <div class="mx-4">
            <h4 class="text-gray-500 text-sm">Top producto</h4>
            <div class="text-2xl font-bold">{{ $data['producto_vendido']['producto']?->nombre ?? '' }}</div>
        </div>
    </div>
    <div class="mt-4 text-gray-500 text-sm">
        {{ $data['producto_vendido']['cantidad'] ?? 0 }} unidades vendidas
    </div>
</div>
