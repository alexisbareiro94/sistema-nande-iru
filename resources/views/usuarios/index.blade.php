@extends('layouts.app')

@section('titulo', 'caja')

@section('ruta-actual', 'Gestión de usuarios')

@section('contenido')
    <!-- Navbar -->
    <header class="flex flex-col md:flex-row md:items-center mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Gestión de Usuarios</h2>
        </div>
    </header>

    <div class=" rounded-xl overflow-hidden p-4">

        <!-- Sección 1: Dashboard / Resumen -->
        <section class="mb-10">
            {{-- <h2 class="text-2xl font-bold mb-4 text-indigo-800 border-b pb-2">Dashboard / Resumen de Usuarios</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Usuarios Activos -->
                <div class="bg-white p-5 rounded-lg shadow-md flex flex-col items-center justify-center text-center">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mb-3">
                        <span class="text-green-600 font-bold">✓</span>
                    </div>
                    <h3 class="font-semibold text-gray-700">Usuarios Activos</h3>
                    <p class="text-2xl font-bold text-gray-900">48</p>
                </div>
                <!-- Total Usuarios Inactivos -->
                <div class="bg-white p-5 rounded-lg shadow-md flex flex-col items-center justify-center text-center">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mb-3">
                        <span class="text-red-600 font-bold">×</span>
                    </div>
                    <h3 class="font-semibold text-gray-700">Usuarios Inactivos</h3>
                    <p class="text-2xl font-bold text-gray-900">12</p>
                </div>
                <!-- Sueldo Total a Pagar -->
                <div class="bg-white p-5 rounded-lg shadow-md flex flex-col items-center justify-center text-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mb-3">
                        <span class="text-blue-600 font-bold">$</span>
                    </div>
                    <h3 class="font-semibold text-gray-700">Sueldo Total (Mes)</h3>
                    <p class="text-2xl font-bold text-gray-900">Gs. {{ moneda($salarios) }}</p>
                </div>
                <!-- Roles Existentes -->
                <div class="bg-white p-5 rounded-lg shadow-md flex flex-col items-center justify-center text-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mb-3">
                        <span class="text-purple-600 font-bold">R</span>
                    </div>
                    <h3 class="font-semibold text-gray-700">Roles Registrados</h3>
                    <p class="text-2xl font-bold text-gray-900">5</p>
                </div>
            </div> --}}

            <!-- Auditoria -->
            <section class="mb-10">
                <h2 class="text-2xl font-bold mb-4 text-indigo-800 border-b pb-2">Auditoria</h2>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4">
                        <a href="{{ route('auditoria.index') }}" class="flex gap-4 items-center">
                            <h3 class="font-bold">Registro de actividad</h3>
                            <p class="flex items-center text-sm text-gray-500 hover:underline cursor-pointer group">
                                Ver todos
                                <i class="ml-2 items-center">
                                    <svg class="w-4 transition-all duration-150 group-hover:translate-x-1"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                    </svg>
                                </i>
                            </p>
                        </a>
                        <div class="mt-3 sm:mt-0">
                            <select class="p-2 border rounded">
                                <option>Mes Actual</option>
                                <option>Mes Anterior</option>
                                <option>Últimos 3 meses</option>
                            </select>
                            <button class="ml-2 bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700">Descargar
                                Reporte</button>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                        Creado por
                                    </th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                        Tipo
                                    </th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                        Datos
                                    </th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                        Fecha
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="table-body-auditorias" class="divide-y divide-gray-200">
                                @foreach ($auditorias as $item)
                                    <tr>
                                        <td class="px-4 py-3">{{ $item->user->name ?? '' }}</td>
                                        <td class="px-4 py-3">{{ $item->accion }}</td>
                                        <td class="px-4 py-3">
                                            @if ($item->datos)
                                                @foreach ($item->datos as $key => $dato)
                                                    {{ $key }}: {{ is_numeric($dato) ? moneda($dato) : $dato }}
                                                    <br>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">{{ format_time($item->created_at) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- Estadísticas por Rol -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="font-bold text-lg mb-4">Empleados</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                    Rol
                                </th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                    Nombre
                                </th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                    Sueldo
                                </th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                    conexión
                                </th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                    ultima actividad
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($users as $user)
                                <tr>
                                    <td class="px-4 py-3">{{ ucfirst($user->role) }}</td>
                                    <td class="px-4 py-3">{{ ucfirst($user->name) }}</td>
                                    <td class="px-4 py-3">Gs. {{ moneda($user->salario) }}</td>
                                    <td id="estado" data-id="{{ $user->id }}" @class([
                                        'td-personal px-4 py-3 font-semibold',
                                        'text-green-500' => $user->en_linea,
                                    ])>
                                        {{ $user->en_linea ? 'En linea' : ($user->ultima_conexion != null ? format_time($user->ultima_conexion) : '') }}
                                    </td>
                                    <td data-userid={{ $user->id }} class="td-total px-4 py-3">Gs.
                                        {{ moneda($user->ultima_venta?->total) ?? '' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- Sección 2: Gestión de Usuarios -->
        <section class="mb-10">
            <h2 class="text-2xl font-bold mb-4 text-indigo-800 border-b pb-2">Gestión de Usuarios</h2>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Crear Usuario -->
                <div class="bg-white p-5 rounded-lg shadow-md">
                    <h3 class="font-bold mb-3">Crear Nuevo Usuario</h3>
                    <form class="space-y-3" action="{{ route('gestion.users.store') }}" method="POST">
                        @csrf
                        <input name="name" type="text" placeholder="Nombre y  Apellido"
                            class="w-full p-2 border rounded" />
                        <input name="email" type="email" placeholder="Email" class="w-full p-2 border rounded" />
                        <div class="relative">
                            <input type="password" name="password" id="password" placeholder="********"
                                class="w-full p-2 border rounded">
                            <span id="mostrar-gu"
                                class="cursor-pointer font-semibold px-2 py-1 hover:bg-gray-200 rounded-lg absolute top-1 right-3">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </span>
                            </span>
                            <span id="ocultar-gu"
                                class="cursor-pointer px-2 py-1 hover:bg-gray-100 absolute top-1 right-3 hidden">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                    </svg>
                                </span>
                            </span>
                        </div>
                        <input name="telefono" type="tel" placeholder="Teléfono"
                            class="w-full p-2 border rounded" />
                        <select name="role" class="w-full p-2 border rounded">
                            <option disabled selected>Rol</option>
                            <option>personal</option>
                            <option>Cajero</option>
                            <option>Vendedor</option>
                            <option>Soporte</option>
                        </select>
                        <select name="activo" class="w-full p-2 border rounded">
                            <option disabled selected>Estado</option>
                            <option value="true">Activo</option>
                            <option value="false">Inactivo</option>
                        </select>
                        <input name="salario" type="number" placeholder="Salario" class="w-full p-2 border rounded" />
                        <button class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700">Crear
                            Usuario</button>
                    </form>
                </div>

                <!-- Editar Usuario -->
                <div class="bg-white p-5 rounded-lg shadow-md">
                    <h3 class="font-bold mb-3">Editar Usuario</h3>
                    <form id="update-personal-form" class="space-y-3">
                        <select id="edit-user" class="w-full p-2 border rounded">
                            <option disabled selected>Seleccionar usuario</option>
                            @foreach ($users as $user)
                                <option @class(['', 'text-gray-300 underline' => $user->activo == false]) value="{{ $user->id }}">{{ $user->name }}
                                    {{ $user->activo == false ? ' - Inactivo' : '' }} </option>
                            @endforeach
                        </select>
                        <input id="name-selected" type="text" placeholder="Nombre" class="w-full p-2 border rounded"
                            value="" />
                        <input id="email-selected" type="email" placeholder="Email" class="w-full p-2 border rounded"
                            value="" />
                        <select id="rol-selected" class="w-full p-2 border rounded">
                            <option>Cajero</option>
                            <option>Personal</option>
                            <option selected>Administrador</option>
                        </select>
                        <input id="salario-selected" type="number" placeholder="Nuevo salario"
                            class="w-full p-2 border rounded" value="" />
                        <button id="btn-actualizar" type="submit"
                            class="w-full bg-yellow-500 text-white py-2 rounded hover:bg-yellow-600">Actualizar</button>
                    </form>
                </div>

                <!-- Eliminar / Desactivar -->
                <div class="bg-white p-5 rounded-lg shadow-md">
                    <h3 class="font-bold mb-3">🗑️ Eliminar / Desactivar</h3>
                    <div class="space-y-3">
                        <select id="personal-activo" class="w-full p-2 border rounded">
                            <option disabled selected>Seleccionar usuario</option>
                            @foreach ($users as $user)
                                @if ($user->activo == true)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        <div class="flex space-x-2">
                            <button id="eliminar"
                                class="delDes-personal flex-1 bg-red-500 text-white py-2 rounded hover:bg-red-600">
                                Eliminar
                            </button>
                            <button id="desactivar"
                                class="delDes-personal flex-1 bg-gray-500 text-white py-2 rounded hover:bg-gray-600">
                                Desactivar
                            </button>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">* Eliminar borra permanentemente. Desactivar lo mantiene en
                            el sistema.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Sección 4: Visualización de Sueldos -->
        <section class="mb-10">
            <h2 class="text-2xl font-bold mb-4 text-indigo-800 border-b pb-2">Pagos de Sueldos</h2>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4">
                    <h3 class="font-bold">Listado de Sueldos</h3>
                    <div class="mt-3 sm:mt-0">
                        <select class="p-2 border rounded">
                            <option>Mes Actual</option>
                            <option>Mes Anterior</option>
                            <option>Últimos 3 meses</option>
                        </select>
                        <button class="ml-2 bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700">Descargar
                            Reporte</button>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Empleado
                                </th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Sueldo</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Fecha Pago
                                </th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($pagos as $pago)
                                <tr>
                                    <td class="px-4 py-3">{{ $pago->user->name }}</td>
                                    <td class="px-4 py-3"> Gs. {{ moneda($pago->monto) }}</td>
                                    <td class="px-4 py-3">{{ format_time($pago->created_at) }}</td>
                                    <td class="px-4 py-3">
                                        <button class="text-blue-600 hover:underline text-sm">Ver recibo</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- Sección 6: Opciones de Seguridad -->
        <section class="mb-10">
            <h2 class="text-2xl font-bold mb-4 text-indigo-800 border-b pb-2">Seguridad</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-5 rounded-lg shadow-md">
                    <h3 class="font-bold mb-2">Cambiar Contraseña</h3>
                    <form method="POST" action="{{ route('gestion.update.admin', ['id' => auth()->user()->id]) }}" class="space-y-2">
                        @csrf
                        <input name="actual_password" type="password" placeholder="Contraseña actual" class="pass w-full p-2 border rounded" />
                        <input name="password" type="password" placeholder="Nueva contraseña" class="pass w-full p-2 border rounded" />
                        <input name="password_confirmation" type="password" placeholder="Confirmar nueva" class="pass w-full p-2 border rounded" />

                        <div class="py-2 cursor-pointer" >
                            <input type="checkbox" name="show-pass" id="show-pass">
                            <label for="show-pass">Mostrar Contraseña</label>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                            Guardar Cambios
                        </button>
                    </form>
                </div>
                <div class="bg-white p-5 rounded-lg shadow-md">
                    <h3 class="font-bold mb-2">Restablecer Contraseña</h3>
                    <form class="space-y-2" action="{{ route('restablecer.pass') }}" method="POST">
                        @csrf
                        <select name="id" class="w-full p-2 border rounded">
                            <option disabled selected>Seleccionar usuario</option>
                            @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>                                
                            @endforeach
                        </select>
                        <button
                            class="w-full bg-orange-500 text-white py-2 rounded hover:bg-orange-600">Restablecer</button>
                        <p class="text-xs text-gray-500">Se enviará un enlace temporal al email del usuario.</p>
                    </form>
                </div>
                <div class="bg-white p-5 rounded-lg shadow-md">
                    <h3 class="font-bold mb-2">Bloqueo Temporal</h3>
                    <form class="space-y-2">
                        <select class="w-full p-2 border rounded">
                            <option disabled selected>Seleccionar usuario</option>
                            <option>Carlos Ruiz</option>
                        </select>
                        <input type="number" placeholder="Horas de bloqueo" class="w-full p-2 border rounded" />
                        <button class="w-full bg-red-600 text-white py-2 rounded hover:bg-red-700">Bloquear</button>
                    </form>
                </div>
            </div>
        </section>

        <!-- Sección 7: Exportación y Reportes -->
        <section class="mb-10">
            <h2 class="text-2xl font-bold mb-4 text-indigo-800 border-b pb-2">📤 Exportación y Reportes</h2>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="font-bold mb-3">📋 Exportar Listado de Usuarios</h3>
                        <p class="text-sm text-gray-600 mb-3">Incluye: nombre, rol, estado, salario, email, teléfono.
                        </p>
                        <div class="flex space-x-2">
                            <button class="bg-gray-700 text-white py-2 px-4 rounded hover:bg-gray-800">Exportar
                                CSV</button>
                            <button class="bg-red-600 text-white py-2 px-4 rounded hover:bg-red-700">Exportar
                                PDF</button>
                        </div>
                    </div>
                    <div>
                        <h3 class="font-bold mb-3">📊 Reporte de Sueldos por Período</h3>
                        <div class="flex space-x-2 mb-3">
                            <input type="date" class="p-2 border rounded" />
                            <input type="date" class="p-2 border rounded" />
                        </div>
                        <button class="bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700">Generar Reporte
                            Contable</button>
                        <p class="text-xs text-gray-500 mt-2">Ideal para enviar al departamento de contabilidad.</p>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        const ocultar = document.getElementById('ocultar-gu');
        const mostrar = document.getElementById('mostrar-gu');
        const input = document.getElementById('password');

        mostrar.addEventListener('click', () => {
            mostrar.classList.add('hidden');
            ocultar.classList.remove('hidden');
            password.type = 'text'
        });

        ocultar.addEventListener('click', () => {
            ocultar.classList.add('hidden');
            mostrar.classList.remove('hidden');
            password.type = 'password'
        });        

        const inputs = document.querySelectorAll('.pass');
        document.getElementById('show-pass').addEventListener('change', () => {
            inputs.forEach(input => {
                if(input.type == 'password'){
                    input.type = 'text';
                }else{
                    input.type = 'password';
                }
            })
        });
    </script>
@endsection
