@extends('layouts.auth')

@section('titulo', 'Login')

@section('contenido')
    <div class="min-h-screen flex items-center justify-center bg-[#A4B6B3] px-4">
        <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-8">
            <h2 class="text-2xl font-bold text-center text-[#000000] mb-6">Iniciar Sesión</h2>
            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                    <input type="email" name="email" id="email" required
                        class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-[#FFC60A] focus:border-[#FFC60A]">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                    <input type="password" name="password" id="password" required
                        class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-[#FFC60A] focus:border-[#FFC60A]">
                </div>

                <div class="flex items-center justify-between text-sm">
                    {{-- <label class="flex items-center">
                    <input type="checkbox" name="remember" class="form-checkbox text-[#FFC60A]">
                    <span class="ml-2 text-gray-700">Recordarme</span>
                </label> --}}
                    <a href="" class="text-[#CC0000] hover:underline">¿Olvidaste tu contraseña?</a>
                </div>

                <div class="items-center text-center">

                    <button type="submit"
                        class="w-full mb-5 bg-[#000000] text-white font-semibold py-2 px-4 rounded-md hover:bg-[#333] transition-colors">
                        Iniciar Sesión
                    </button>
                    {{-- <a href="{{ route('register.view') }}"
                        class="cursor-pointer w-full mt-6 bg-white text-black font-semibold py-2 px-4 rounded-md hover:underline transition-colors">
                        Registro
                    </a> --}}
                </div>
            </form>
        </div>
    </div>
@endsection
