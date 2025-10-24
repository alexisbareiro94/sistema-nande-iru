@extends('layouts.auth')

@section('titulo', 'Restablecer Contraseña')

@section('contenido')
    <div class="min-h-screen flex items-center justify-center bg-[#A4B6B3] px-4">
        <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-8">
            <h2 class="text-2xl font-bold text-center text-[#000000] mb-6">Restablecer Contraseña</h2>

            <form action="{{ route('reset.password', ['id' => Crypt::encrypt($user->id)]) }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    Hola, {{ $user->name }}
                    <p>
                        aquí puedes cambiar tu contraseña
                    </p>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Nueva Contraseña</label>
                    <input type="password" name="password" id="password" required
                        class="pass mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-[#FFC60A] focus:border-[#FFC60A]">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar
                        Contraseña</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="pass mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-[#FFC60A] focus:border-[#FFC60A]">
                </div>

                <div>
                    <input type="checkbox" name="show-pass" id="show-pass">
                    <label for="show-pass" class="cursor-pointer">
                        Mostrar contraseña
                    </label>
                </div>

                <div class="items-center text-center">

                    <button type="submit"
                        class="w-full mb-5 bg-[#000000] text-white font-semibold py-2 px-4 rounded-md hover:bg-[#333] transition-colors">
                        Confirmar
                    </button>                    
                </div>
            </form>
        </div>
    </div>

    <script>
        const inputs = document.querySelectorAll('.pass');
        document.getElementById('show-pass').addEventListener('change', () => {
            inputs.forEach(item => {
                if (item.type == 'password') {
                    item.type = 'text'
                } else {
                    item.type = 'password'
                }
            })
        });
    </script>
@endsection
