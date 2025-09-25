 <div class="col-span-2 bg-white rounded-lg shadow p-6 min-h-20 my-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-700">Evolución de Egresos</h3>
                            <div class="flex space-x-2 bg-gray-300  rounded-lg">
                                <button id="7d" data-egreso="7"
                                    class="egreso-btn cursor-pointer text-xs px-3 py-1 transition-all duration-300 ease-in-out border border-gray-300 bg-gray-50 font-semibold rounded-md shadow-lg">7D</button>
                                <button id="30d" data-egreso="30"
                                    class="egreso-btn cursor-pointer text-xs px-3 py-1 transition-all duration-300 ease-in-out border border-gray-300 bg-gray-300 font-semibold rounded-md">30D</button>
                                <button id="90d" data-egreso="90"
                                    class="egreso-btn cursor-pointer text-xs px-3 py-1 transition-all duration-300 ease-in-out border border-gray-300 bg-gray-300 font-semibold rounded-md">90D</button>
                            </div>
                        </div>
                        <div class="h-100">
                            <div class="h-full flex items-end space-x-2">
                                <canvas id="egresosChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- grafico de coneptos de egresos -->
                    <div class="col-span-1 bg-white rounded-lg shadow p-6 min-h-20 my-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-md font-semibold text-gray-700">Concepto de Egresos</h3>
                            <div class="flex space-x-2 bg-gray-300  rounded-lg">
                                <button id="7d" data-concepto="7"
                                    class="concepto-btn cursor-pointer text-xs px-3 py-1 transition-all duration-300 ease-in-out border border-gray-300 bg-gray-50 font-semibold rounded-md shadow-lg">7D</button>
                                <button id="30d" data-concepto="30"
                                    class="concepto-btn cursor-pointer text-xs px-3 py-1 transition-all duration-300 ease-in-out border border-gray-300 bg-gray-300 font-semibold rounded-md">30D</button>
                                <button id="90d" data-concepto="90"
                                    class="concepto-btn cursor-pointer text-xs px-3 py-1 transition-all duration-300 ease-in-out border border-gray-300 bg-gray-300 font-semibold rounded-md">90D</button>
                            </div>
                        </div>
                        <div class="h-100">
                            <div class="h-full flex items-end space-x-2">
                                <canvas id="egresosConceptoChart"></canvas>
                            </div>
                        </div>
                    </div>