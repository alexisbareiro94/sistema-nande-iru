<div class="p-6 min-h-screen">
    <h1 class="text-xl font-bold mb-8">
        {{-- <a href="/">
            <img class="w-26 ml-6" src="{{ asset('images/logo/logo.png') }}" alt="">
        </a> --}}
        <p>{{ auth()->user()->admin->empresa }}</p>
    </h1>
    <nav>
        <ul class="space-y-2">
            <li>
                <a href="{{ route('home') }}"
                    class="flex items-center p-3 rounded-lg hover:bg-[#b6c4c2] hover:text-gray-800 hover:scale-110 transition-all hover:shadow-xl">
                    <span class="font-semibold">Inicio</span>
                </a>
            </li>
            <li>
                <a href="#"
                    class="flex items-center p-3 rounded-lg hover:bg-[#b6c4c2] hover:text-gray-800 hover:scale-110 transition-all hover:shadow-xl">

                    <span class="font-semibold text-sm">
                        Gestión de Clientes y Distribuidores
                    </span>
                </a>
            </li>
            <li>
                <a href="#"
                    class="flex items-center p-3 rounded-lg hover:bg-[#b6c4c2] hover:text-gray-800 hover:scale-110 transition-all hover:shadow-xl">
                    <span class="font-semibold">Caja</span>
                </a>
            </li>
            <li>
                <a href="#"
                    class="flex items-center p-3 rounded-lg hover:bg-[#b6c4c2] hover:text-gray-800 hover:scale-110 transition-all hover:shadow-xl">
                    <span class="font-semibold">Inventario</span>
                </a>
            </li>
            <li>
                <a href="#"
                    class="flex items-center p-3 rounded-lg hover:bg-[#b6c4c2] hover:text-gray-800 hover:scale-110 transition-all hover:shadow-xl">
                    <span class="font-semibold">Gestión de Usuarios</span>
                </a>
            </li>
            <li>
                <a href="#"
                    class="flex items-center p-3 rounded-lg hover:bg-[#b6c4c2] hover:text-gray-800 hover:scale-110 transition-all hover:shadow-xl">
                    <span class="font-semibold">Reportes</span>
                </a>
            </li>
            <li class="border-t border-gray-400 mt-10">
                <a href="#"
                    class="flex items-center p-3 rounded-lg hover:bg-[#b6c4c2] hover:text-gray-800 hover:scale-110 transition-all hover:shadow-xl">
                    <span class="font-semibold">Perfil</span>
                </a>
            </li>
            <li>
                <span id="cerrar-sesion"
                    class="flex items-center p-3 rounded-lg hover:bg-[#b6c4c2] hover:text-gray-800 hover:scale-110 transition-all hover:shadow-xl">
                    <span class="hover:text-[#CC0000] font-semibold cursor-pointer flex gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                        </svg>
                        Cerrar sesion
                    </span>
            </li>

        </ul>
    </nav>
</div>
