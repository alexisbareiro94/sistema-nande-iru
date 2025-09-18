  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
      <!-- Total Productos -->
      <div id="total-productos"
          class="cursor-pointer bg-yellow-50 p-5 rounded-xl shadow-sm border-2 border-yellow-400 hover:shadow-md transition-shadow duration-200">
          <div class="flex items-center">
              <div class="p-3 rounded-full bg-yellow-200">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24"
                      stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                  </svg>
              </div>
              <div class="ml-4">
                  <p class="text-gray-500 text-sm font-medium">Total Productos</p>
                  <p id="total-productos-i" class="text-2xl font-bold text-gray-900">{{ $total }}</p>
              </div>
          </div>
      </div>

      <!-- Stock Mínimo -->
      <div id="stock-minimo"
          class="cursor-pointer bg-orange-50 p-5 rounded-xl shadow-sm border-2 border-orange-400 hover:shadow-md transition-shadow duration-200">
          <div class="flex items-center">
              <div class="p-3 rounded-full bg-orange-200">
                  <svg class="h-6 w-6 text-orange-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                      viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                      <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                  </svg>
              </div>
              <div class="ml-4">
                  <p class="text-gray-500 text-sm font-medium">Stock Mínimo</p>
                  <p id="stock-minimo-i" class="text-2xl font-bold text-gray-900">{{ $stock }}</p>
              </div>
          </div>
      </div>

      <!-- Sin Stock -->
      <div id="sin-stock"
          class="cursor-pointer bg-red-50 p-5 rounded-xl shadow-sm border-2 border-red-400 hover:shadow-md transition-shadow duration-200">
          <div class="flex items-center">
              <div class="p-3 rounded-full bg-red-200">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none"
                      viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                  </svg>
              </div>
              <div class="ml-4">
                  <p class="text-gray-500 text-sm font-medium">Sin Stock</p>
                  <p id="sin-stock-i" class="text-2xl font-bold text-gray-900">{{ $sinStock }}</p>
              </div>
          </div>
      </div>
      <!-- Servicios -->
      <div id="servicios"
          class="cursor-pointer bg-green-50 p-5 rounded-xl shadow-sm border-2 border-green-400 hover:shadow-md transition-shadow duration-200">
          <div class="flex items-center">
              <div class="p-3 rounded-full bg-green-200">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none"
                      viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
              </div>
              <div class="ml-4">
                  <p class="text-gray-500 text-sm font-medium">Servicios</p>
                  <p id="servicios-i" class="text-2xl font-bold text-gray-900">{{ $totalServicios }}</p>
              </div>
          </div>
      </div>

      <!-- Productos -->
      <div id="productos"
          class="cursor-pointer bg-blue-50 p-5 rounded-xl shadow-sm border-2 border-blue-400 hover:shadow-md transition-shadow duration-200">
          <div class="flex items-center">
              <div class="p-3 rounded-full bg-blue-200">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none"
                      viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                  </svg>
              </div>
              <div class="ml-4">
                  <p class="text-gray-500 text-sm font-medium">Productos</p>
                  <p id="productos-i" class="text-2xl font-bold text-gray-900">{{ $totalProductos }}</p>
              </div>
          </div>
      </div>
  </div>
