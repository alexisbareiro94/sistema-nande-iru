<div class="col-span-1 mt-4">
    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm hover:shadow-md transition-shadow duration-200">
        <!-- Ganancia Actual -->
        <div class="mb-5">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Ganancia Actual</p>
            <p id="ganancia-actual" class="text-2xl font-bold text-gray-900 mt-1">
                Gs. {{ number_format($data['utilidad']['actual']['ganancia'], 0, ',', '.') }}
            </p>
            <p id="rango-actual" class="text-xs text-gray-500 mt-2">
                Rango: Hoy ({{ Carbon\Carbon::parse($data['utilidad']['actual']['fecha_apertura'])->format('d-m') }})
            </p>
        </div>

        <!-- Comparación con periodo anterior -->
        <div id="cont-diff" class="pt-4 border-t border-gray-100 flex justify-between items-start">
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">vs Periodo Anterior</p>
                <p class="mt-1.5">
                    <span id="ganancia-anterior" class="text-lg font-semibold text-gray-800">
                        Gs. {{ number_format($data['utilidad']['pasado']['ganancia'], 0, ',', '.') }}
                    </span>
                </p>
                <p id="rango-anterior" class="text-xs text-gray-500 mt-2">
                    Rango: Ayer ({{ Carbon\Carbon::parse($data['utilidad']['pasado']['fecha_apertura'])->format('d-m') }})
                </p>
            </div>

            <!-- Porcentaje y diferencia -->
            <div class="text-right">
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Diferencia</p>
                <div class="mt-1.5 flex flex-col items-end">
                    <span id="variacion-porcentaje"
                        class="text-sm font-semibold {{ $data['utilidad']['tag'] === '+' ? 'text-green-700 bg-green-200 rounded-xl px-1' : 'text-red-700 bg-red-200 rounded-xl px-1' }}">
                        {{ $data['utilidad']['tag'] }}{{ $data['utilidad']['porcentaje'] }}%
                    </span>
                    <span class="text-sm font-medium text-gray-600 mt-1" id="variacion-valor">
                        Gs. {{ number_format($data['utilidad']['diferencia'], 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>