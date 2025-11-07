<div class="col-span-1 mt-4">
    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm hover:shadow-md transition-shadow duration-200">
        <!-- Ganancia Actual -->
        <div class="mb-5 flex justify-between">
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Ganancia Actual</p>
                <p id="ganancia-actual" class="text-2xl font-bold text-gray-900 mt-1">
                    Gs. {{ number_format($data['utilidad']['actual']['ganancia'] ?? 0, 0, ',', '.') }}
                </p>
                <p id="rango-actual" class="text-xs text-gray-500 mt-2">
                    Rango: Hoy
                    ({{ Carbon\Carbon::parse($data['utilidad']['actual']['fecha_apertura'] ?? now())->format('d-m') }})
                </p>
            </div>

            <span id="svg-cont-card" @class([
                'text-red-500' => $data['utilidad']['tag'] ?? '' == '-',
                'text-green-500' => $data['utilidad']['tag'] ?? '' == '+',
                'text-gray-500' => '',
            ])>
                @if ($data['utilidad']['tag'] ?? '' == '-')
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 6 9 12.75l4.286-4.286a11.948 11.948 0 0 1 4.306 6.43l.776 2.898m0 0 3.182-5.511m-3.182 5.51-5.511-3.181" />
                    </svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941" />
                    </svg>
                @endif
            </span>

        </div>

        <!-- Comparación con periodo anterior -->
        <div id="cont-diff" class="pt-4 border-t border-gray-300 flex justify-between items-start">
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">vs Periodo Anterior</p>
                <p class="mt-1.5">
                    <span id="ganancia-anterior" class="text-lg font-semibold text-gray-800">
                        Gs. {{ number_format($data['utilidad']['pasado']['ganancia'] ?? 0, 0, ',', '.') }}
                    </span>
                </p>
                <p id="rango-anterior" class="text-xs text-gray-500 mt-2">
                    Rango: Ayer
                    ({{ Carbon\Carbon::parse($data['utilidad']['pasado']['fecha_apertura'] ?? now())->format('d-m') }})
                </p>
            </div>

            <!-- Porcentaje y diferencia -->
            <div class="text-right">
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Diferencia</p>
                <div class="mt-1.5 flex flex-col items-end">
                    <span id="variacion-porcentaje"
                        class="text-sm font-semibold {{ $data['utilidad']['tag'] ?? '+' === '+' ? 'text-green-700 bg-green-200 rounded-xl px-1' : 'text-red-700 bg-red-200 rounded-xl px-1' }}">
                        {{ $data['utilidad']['tag'] ?? ''}} {{ $data['utilidad']['porcentaje'] ?? '' }}%
                    </span>
                    <span class="text-sm font-medium text-gray-600 mt-1" id="variacion-valor">
                        Gs. {{ number_format($data['utilidad']['diferencia'] ?? 0, 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
