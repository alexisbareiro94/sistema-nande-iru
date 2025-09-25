<div class="lg:col-span-2 bg-white rounded-lg shadow p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-700">Evolución de Ventas</h3>
                            <div class="flex space-x-2 bg-gray-300  rounded-lg">
                                <button id="7d" data-periodo="7"
                                    class="periodo-btn cursor-pointer text-xs px-3 py-1 transition-all duration-300 ease-in-out border border-gray-300 bg-gray-50 font-semibold rounded-md shadow-lg">7D</button>
                                <button id="30d" data-periodo="30"
                                    class="periodo-btn cursor-pointer text-xs px-3 py-1 transition-all duration-300 ease-in-out border border-gray-300 bg-gray-300 font-semibold rounded-md">30D</button>
                                <button id="90d" data-periodo="90"
                                    class="periodo-btn cursor-pointer text-xs px-3 py-1 transition-all duration-300 ease-in-out border border-gray-300 bg-gray-300 font-semibold rounded-md">90D</button>
                            </div>
                        </div>
                        <div class="h-100">
                            <div class="h-full flex items-end space-x-2">
                                <canvas id="ventasChart">
                                    <div class="flex gap-4">
                                        <canvas id="ingresos"></canvas>
                                    </div>
                                </canvas>
                            </div>
                        </div>
                    </div>
