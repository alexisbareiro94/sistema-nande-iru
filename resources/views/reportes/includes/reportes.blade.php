<div class="flex justify-between items-center mb-4">
    <h3 class="text-lg font-semibold text-gray-700">Reportes</h3>
    <div class="flex space-x-2">
        <button class="px-3 py-1 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm flex items-center">
            <i class="fas fa-file-export mr-1"></i> Exportar
        </button>
        <button class="px-3 py-1 bg-primary hover:bg-secondary text-white rounded-lg text-sm flex items-center">
            <i class="fas fa-download mr-1"></i> Descargar PDF
        </button>
    </div>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="cursor-pointer border rounded-lg p-4 hover:shadow-md transition-shadow">
        <div class="flex items-center">
            <div class="p-2 bg-blue-100 text-primary rounded-lg">
                <i class="fas fa-file-invoice text-xl"></i>
            </div>
            <div class="ml-4">
                <h4 class="font-medium">Reporte de Ventas</h4>                
                <p class="text-sm text-gray-500">Ventas detalladas por periodo</p>
            </div>
        </div>
    </div>
    <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
        <div class="flex items-center">
            <div class="p-2 bg-green-100 text-accent rounded-lg">
                <i class="fas fa-cash-register text-xl"></i>
            </div>
            <div class="ml-4">
                <h4 class="font-medium">Movimientos de Caja</h4>
                <p class="text-sm text-gray-500">Aperturas, cierres y diferencias</p>
            </div>
        </div>
    </div>
    <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
        <div class="flex items-center">
            <div class="p-2 bg-purple-100 text-purple-500 rounded-lg">
                <i class="fas fa-boxes text-xl"></i>
            </div>
            <div class="ml-4">
                <h4 class="font-medium">Reporte de Stock</h4>
                <p class="text-sm text-gray-500">Inventario y productos bajos</p>
            </div>
        </div>
    </div>
</div>
