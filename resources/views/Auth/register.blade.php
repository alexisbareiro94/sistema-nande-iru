@extends('layouts.auth')

@section('titulo', 'Registro')

@section('contenido')
    <div class="min-h-screen flex items-center justify-center bg-[#A4B6B3] px-4">
        <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-8">
            <h2 class="text-2xl font-bold text-center text-[#000000] mb-6">Crear Cuenta</h2>

            <form action="{{ route('register') }}" method="POST" class="space-y-4">
                @csrf

                {{-- Nombre --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input type="text" name="name" id="name" required value="{{ old('name') }}"
                           class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-[#FFC60A] focus:border-[#FFC60A]">
                </div>

                {{-- Correo --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                    <input type="email" name="email" id="email" required value="{{ old('email') }}"
                           class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-[#FFC60A] focus:border-[#FFC60A]">
                </div>

                {{-- Contraseña --}}
                <div class="relative">
                    <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                    <input type="password" name="password" id="password" required
                           class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-[#FFC60A] focus:border-[#FFC60A]">

                    <span id="ocultar-pass" class="absolute right-3 top-8 cursor-pointer hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                    </span>


                    <span id="mostrar-pass" class="absolute right-3 top-8 cursor-pointer z-50">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </span>
                </div>

                {{-- Confirmación de contraseña --}}
                <div class="relative">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar contraseña</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                           class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-[#FFC60A] focus:border-[#FFC60A]">

                    <span id="ocultar-pass-conf" class="absolute right-3 top-8 cursor-pointer hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                    </span>


                    <span id="mostrar-pass-conf" class="absolute right-3 top-8 cursor-pointer z-50">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </span>

                </div>

                {{-- Botón --}}
                <div class="items-center text-center">
                    <button type="submit"
                            class="w-full mb-5 bg-[#000000] text-white font-semibold py-2 px-4 rounded-md hover:bg-[#333] transition-colors">
                        Registrarse
                    </button>
                    <a href="{{ route('login') }}"
                       class="cursor-pointer w-full mt-6 bg-white text-black font-semibold py-2 px-4 rounded-md hover:underline transition-colors">
                        Ya tengo cuenta
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        const mostarPass = document.getElementById('mostrar-pass');
        const ocultarPass = document.getElementById('ocultar-pass');
        const passwordInput = document.getElementById('password');

        mostarPass.addEventListener('click', () => {
            mostarPass.classList.add('hidden');
            mostarPass.classList.remove('z-50');

            ocultarPass.classList.add('z-50');
            ocultarPass.classList.remove('hidden');

            passwordInput.type = 'text';
        });

        ocultarPass.addEventListener('click', () => {
            mostarPass.classList.remove('hidden');
            mostarPass.classList.add('z-50');

            ocultarPass.classList.remove('z-50');
            ocultarPass.classList.add('hidden');

            passwordInput.type = 'password';
        });

        const toggleBtnConfirm = document.querySelectorAll('#mostrar-pass-conf, #ocultar-pass-conf');
        const passConfirmation = document.getElementById('password_confirmation');

        toggleBtnConfirm.forEach(btn => {
            btn.addEventListener('click', () => {
                if(btn.classList.contains('z-50')) {
                    passConfirmation.type = passConfirmation.type === 'password' ? 'text' : 'password';
                    toggleBtnConfirm.forEach(el => {
                        el.classList.toggle('hidden');
                        el.classList.toggle('z-50');
                    });
                }
            });
        });

    </script>
@endsection

