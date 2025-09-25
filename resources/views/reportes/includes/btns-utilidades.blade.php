<div class="flex flex-wrap items-center gap-6">
                            <!-- Grupo de botones de rango de tiempo -->
                            <div>
                                <label class="text-sm font-medium text-gray-600 mb-1 block">Periodo</label>
                                <div class="flex space-x-2 bg-gray-300 rounded-lg">
                                    <button id="7dp" data-utilidad="dia"
                                        class="utilidad-btn cursor-pointer text-xs px-3 py-1 transition-all duration-300 ease-in-out border border-gray-300 bg-gray-50 font-semibold rounded-md shadow-lg">
                                        Diario
                                    </button>
                                    <button id="30dp" data-utilidad="semana"
                                        class="utilidad-btn cursor-pointer text-xs px-3 py-1 transition-all duration-300 ease-in-out border border-gray-300 bg-gray-300 font-semibold rounded-md">
                                        Semana
                                    </button>
                                    <button id="90dp" data-utilidad="mes"
                                        class="utilidad-btn cursor-pointer text-xs px-3 py-1 transition-all duration-300 ease-in-out border border-gray-300 bg-gray-300 font-semibold rounded-md">
                                        Mensual
                                    </button>
                                </div>
                            </div>

                            <!-- Grupo de botones de comparación -->
                            <div>
                                <label class="text-sm font-medium text-gray-600 mb-1 block">Comparar con hoy</label>
                                <div class="flex space-x-2 bg-gray-300 rounded-lg max-w-[90px]">
                                    <button
                                        class="option-btn cursor-pointer text-xs px-3 py-1 transition-all duration-300 ease-in-out border border-gray-300 bg-gray-50 font-semibold rounded-md shadow-lg">
                                        NO
                                    </button>
                                    <button data-option="hoy"
                                        class="option-btn cursor-pointer text-xs px-4 py-1 transition-all duration-300 ease-in-out border border-gray-300 bg-gray-300 font-semibold rounded-md">
                                        SI
                                    </button>
                                </div>
                            </div>

                            <!-- Grupo de botones de egreso -->
                            <div>
                                <label class="text-sm font-medium text-gray-600 mb-1 block">Restar Egresos</label>
                                <div class="flex space-x-2 bg-gray-300 rounded-lg">
                                    <button
                                        class="regreso-btn cursor-pointer text-xs px-3 py-1 transition-all duration-300 ease-in-out border border-gray-300 bg-gray-50 font-semibold rounded-md shadow-lg">
                                        NO
                                    </button>
                                    <button data-regreso="true"
                                        class="regreso-btn cursor-pointer text-xs px-4 py-1 transition-all duration-300 ease-in-out border border-gray-300 bg-gray-300 font-semibold rounded-md">
                                        SI
                                    </button>
                                </div>
                            </div>
                        </div>