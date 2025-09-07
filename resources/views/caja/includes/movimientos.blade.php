<div class="card rounded-xl p-5">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold text-amarillo">Últimos movimientos</h2>
        <a href="{{ route('venta.index.view') }}" class="cursor-pointer text-gris hover:text-amarillo transition-colors">
            Ver todo el historial →
        </a>
    </div>

    <div id="movimiento-cont" class="space-y-3 max-h-60 overflow-y-auto pr-2">
        <div class="flex items-center justify-between p-3 bg-gray-800/50 rounded-lg">
            <svg id="loader-saldo" class="animate-spin h-11 w-10 text-amarillo" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                </circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z">
                </path>
            </svg>
        </div>

        <div class="flex items-center justify-between p-3 bg-gray-800/50 rounded-lg">
            <svg id="loader-saldo" class="animate-spin h-11 w-10 text-amarillo" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                </circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z">
                </path>
            </svg>
        </div>

        <div class="flex items-center justify-between p-3 bg-gray-800/50 rounded-lg">
            <svg id="loader-saldo" class="animate-spin h-11 w-10 text-amarillo" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                </circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z">
                </path>
            </svg>
        </div>
    </div>
</div>
