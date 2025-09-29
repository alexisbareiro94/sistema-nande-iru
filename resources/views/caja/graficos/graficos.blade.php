   <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
       <!-- Título -->
       <h3 class="text-2xl font-bold text-gray-800">Estadísticas de ingresos y egresos por Dia</h3>
       <span id="recargar-chart" title="Recargar tabla"
           class="cursor-pointer transition-transform duration-200 hover:rotate-45">
           <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
               stroke="currentColor" class="size-6">
               <path stroke-linecap="round" stroke-linejoin="round"
                   d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
           </svg>
       </span>

       <!-- Formulario de fechas -->
       <form action="" id="dv-form-fecha"
           class="flex flex-col sm:flex-row items-center gap-3 bg-gray-50 rounded-lg p-4">
           <div class="pr-12 flex flex-col gap-1">
               <label for="periodoInicio" class="text-sm font-medium text-gray-700">Seleccionar Periodo</label>
               <select class="px-3 py-2 border border-gray-300 rounded-md items-center" name="periodoInicio"
                   id="dv-periodo">
                   <option value="semana">Semana</option>
                   <option value="mes">Mes</option>
                   <option value="anio">Año</option>
               </select>
           </div>
           <div class="flex flex-col gap-1">
               <label for="dv-fecha-desde" class="text-sm font-medium text-gray-700">Desde:</label>
               <input
                   class="border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-gray-500 focus:border-transparent transition-all"
                   type="date" id="dv-fecha-desde" name="dv-fecha-desde"
                   value="{{ now()->startOfWeek()->format('Y-m-d') }}">
           </div>

           <div class="flex flex-col gap-1">
               <label for="dv-fecha-hasta" class="text-sm font-medium text-gray-700">Hasta:</label>
               <input
                   class="border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-gray-500 focus:border-transparent transition-all"
                   type="date" id="dv-fecha-hasta" name="dv-fecha-hasta"
                   value="{{ now()->endOfWeek()->format('Y-m-d') }}">
           </div>

           <button type="submit"
               class="cursor-pointer bg-gray-600 mt-6 text-white px-4 py-2 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors font-medium">
               Aplicar filtro
           </button>
       </form>
   </div>
   <canvas id="myChart">
       <div class="flex gap-4">
           <canvas id="chartIngresos"></canvas>
           <canvas id="chartEgresos"></canvas>
       </div>
   </canvas>
