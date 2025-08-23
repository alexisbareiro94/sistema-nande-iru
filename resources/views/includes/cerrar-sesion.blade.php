<div id="main"
    class="hidden fixed inset-0 bg-black/50 z-50 top-0 flex justify-center items-center overflow-y-auto overflow-x-hidden">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm">    
            <div class="p-4 md:p-5 text-center">
                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <h3 class="mb-5 text-lg font-normal text-gray-500">Estas seguro de cerrar sesion?</h3>

                <div class="flex items-center object-center text-center mx-auto justify-center">
                    <button data-modal-hide="popup-modal" type="button" id="cancelar"
                        class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        No, cancelar
                    </button>
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit"
                            class="cursor-pointer py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:ring-4 focus:ring-gray-100">
                            Si, cerrar sesion
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>    
    const cerrarModal = document.getElementById("cancelar");
    const btnCerrarSesion = document.getElementById("cerrar-sesion");
    const main = document.getElementById("main");

    btnCerrarSesion.addEventListener('click', function() {
        main.classList.remove("hidden");
    });

    cerrarModal.addEventListener('click', function() {
        main.classList.add("hidden");
    })
</script>
