<div id="import-productos" class="hidden fixed inset-0 bg-black/20 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 border border-gray-200 relative">
        <!-- Botón de cierre -->
        <button id=""
            class="cursor-pointer close-import absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 transition-colors">
            &times;
        </button>

        <!-- Encabezado -->
        <div class="text-center mb-6">
            <h2 class="text-xl font-bold text-gray-800">Importar desde Excel</h2>
            <p class="text-xs italic text-gray-600 mt-2">
                Revise el <a class="font-semibold text-blue-600 hover:underline" href="#">documento</a>
                o <a class="font-semibold text-blue-600 hover:underline" href="#">video</a>
                de guía antes de importar, así evitará errores.
            </p>
        </div>

        <!-- Formulario -->
        <form class="space-y-6" id="import-form">
            <!-- Área de carga de archivo -->
            <div>
                <div id="import-cont"class="flex items-center justify-center w-full">
                    <label for="import-doc"
                        class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <img class="w-9 h-9 mb-4"
                                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAACXBIWXMAAAsTAAALEwEAmpwYAAACcklEQVR4nO2ZvWtUQRDAf/HiRwQNaoSoINrYpgiCFjYWghGCwcpCEElpISgq/g2CoIUIgiDYpRARLcQiEZFAIuQwCZgUFmJAC1ETCzUZWZjAMuwl9/F2b09vYHiwM7czv9vdt7P7oC2tJRJJZ4DefwFEUsOIaow+k8JIRJApfZaB3QXHSAqyA5hINTISEQQdiakUMBIZZBWmHBtGEoAkgZFEINFhJCGIk2gwqUGiwTQDJApMs0AKh4ldotSi5SKCFimNFJpZgTQlD/nfQG4FpsFQBd97xm8O2FJQHg13sB1YMAm+BTqM3yHgl/EbyG1qDQdG5YTxGTH2kQh5NNzBBmDcJDrq2Q8DK55tCTiQ62I/apJ1ekxtL0371Yh5FNLBQ5PwE4Xx29xOvSl3kL3AD++3bnE/NiDHE+RRSAfX19idH9XRnzQLZDPwPgDxHdiTMI+GO9gKzAdAfgN9rQRy0wD4b7KxwEYZXaQOkD7951d/Owu8MmDnyRykU0sTP+lLmrjf9hnYWWVsCWh0kGsm4Add+CXgnbHdzRXkILBoAp7z7KeNbRk4UmNsiQ3iFu+LwNHU1V++vDY+kzpa2YBcCAz/yYCfLVWcXswFpAf4skbVa+WZ8f2mZU01sZMt9iJF2iABaYPUKHeq3DOkgt7OBaSkBzCpA+S5VhTZTK1t3mc4922xq4Kfuzp6o37TQHeOa2Qf8FFjuiNzSO6r3V0/7c95sffrDYuLe9nYrmj7z3XKm2zeWme0FnN6StvcHdkfPducrbVDSayfvOlyQ9u+AoP6FL0PIHcQMQvY3hM/oEVlo3ex547I7mzTsrILeLreifIvjZYgwIoi7VAAAAAASUVORK5CYII="
                                alt="export-excel">
                            <p class="mb-2 text-sm text-gray-500">
                                <span class="font-semibold">Haga clic para cargar</span> para seleccionar documento
                            </p>
                            <p class="text-xs text-gray-500">
                                XLSX, XLS (MÁX. 10MB)
                            </p>
                        </div>
                        <input id="import-doc" name="productos"  type="file" class="hidden" accept=".xlsx,.xls" />
                    </label>
                </div>
            </div>

            <!-- Vista previa del archivo -->
            <div id="preview-cont-file" class="hidden bg-gray-100 rounded-lg p-4 border border-gray-200">
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-5 font-semibold">

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>

                        <p id="preview-file" class="text-sm text-gray-700"></p>
                    </span>
                    <button type="button" id="remove-file" class="cursor-pointer text-gray-500 hover:text-red-700 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>

                    </button>
                </div>
            </div>


            <!-- Botones de acción -->
            <div class="flex flex-col sm:flex-row gap-3 pt-4">
                <button type="button"
                    class="cursor-pointer close-import flex-1 px-4 py-2 bg-gray-200 text-gray-800 font-medium rounded-lg hover:bg-gray-300 transition-colors">
                    Cancelar
                </button>
                <button type="submit"
                    class="cursor-pointer flex-1 px-4 py-2 bg-gray-800 text-white font-medium rounded-lg hover:bg-gray-700 transition-colors">
                    Importar Productos
                </button>
            </div>
        </form>
    </div>
</div>


<script>
    const btns = document.querySelectorAll('.close-import');
    btns.forEach(btn => {
        btn.addEventListener('click', () => {
            document.getElementById('import-productos').classList.add('hidden');
        })
    })
</script>
