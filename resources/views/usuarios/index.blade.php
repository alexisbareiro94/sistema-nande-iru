@extends('layouts.app')

@section('titulo', 'caja')

@section('ruta-actual', 'Gestión de usuarios')

@section('contenido')
    <!-- Navbar -->
    <div class="flex flex-col md:flex-row md:items-center mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Gestión de Caja</h2>
        </div>
    </div>

    <div class=" rounded-xl overflow-hidden p-4">

        <!-- Sección 1: Dashboard / Resumen -->
        <section class="mb-10">
            <h2 class="text-2xl font-bold mb-4 text-indigo-800 border-b pb-2">📊 Dashboard / Resumen de Usuarios</h2>
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
                    <p class="text-2xl font-bold text-gray-900">$18,500</p>
                </div>
                <!-- Roles Existentes -->
                <div class="bg-white p-5 rounded-lg shadow-md flex flex-col items-center justify-center text-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mb-3">
                        <span class="text-purple-600 font-bold">R</span>
                    </div>
                    <h3 class="font-semibold text-gray-700">Roles Registrados</h3>
                    <p class="text-2xl font-bold text-gray-900">5</p>
                </div>
            </div>

            <!-- Estadísticas por Rol -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="font-bold text-lg mb-4">👥 Empleados por Rol</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Rol</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Cantidad
                                </th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Sueldo
                                    Promedio
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr>
                                <td class="px-4 py-3">Administrador</td>
                                <td class="px-4 py-3">3</td>
                                <td class="px-4 py-3">$4,000</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3">Cajero</td>
                                <td class="px-4 py-3">15</td>
                                <td class="px-4 py-3">$1,200</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3">Vendedor</td>
                                <td class="px-4 py-3">25</td>
                                <td class="px-4 py-3">$1,500</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3">Soporte</td>
                                <td class="px-4 py-3">5</td>
                                <td class="px-4 py-3">$1,300</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- Sección 2: Gestión de Usuarios -->
        <section class="mb-10">
            <h2 class="text-2xl font-bold mb-4 text-indigo-800 border-b pb-2">👥 Gestión de Usuarios</h2>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Crear Usuario -->
                <div class="bg-white p-5 rounded-lg shadow-md">
                    <h3 class="font-bold mb-3">➕ Crear Nuevo Usuario</h3>
                    <form class="space-y-3" action="{{ route('gestion.users.store') }}" method="POST">
                        @csrf
                        <input name="name" type="text" placeholder="Nombre y  Apellido" class="w-full p-2 border rounded" />
                        <input name="email" type="email" placeholder="Email" class="w-full p-2 border rounded" />
                        <input name="telefono" type="tel" placeholder="Teléfono" class="w-full p-2 border rounded" />
                        <select name="role" class="w-full p-2 border rounded">
                            <option disabled selected>Rol</option>
                            <option>personal</option>
                            <option>Cajero</option>
                            <option>Vendedor</option>
                            <option>Soporte</option>
                        </select>
                        <select name="estado" class="w-full p-2 border rounded">
                            <option disabled selected>Estado</option>
                            <option value="true" >Activo</option>
                            <option value="false">Inactivo</option>
                        </select>
                        <input name="salario" type="number" placeholder="Salario" class="w-full p-2 border rounded" />
                        <button class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700">Crear
                            Usuario</button>
                    </form>
                </div>                

                <!-- Editar Usuario -->
                <div class="bg-white p-5 rounded-lg shadow-md">
                    <h3 class="font-bold mb-3">✏️ Editar Usuario</h3>
                    <form class="space-y-3">
                        <select class="w-full p-2 border rounded">
                            <option disabled selected>Seleccionar usuario</option>
                            <option>Juan Pérez</option>
                            <option>María Gómez</option>
                        </select>
                        <input type="text" placeholder="Nombre" class="w-full p-2 border rounded" value="Juan" />
                        <input type="text" placeholder="Apellido" class="w-full p-2 border rounded" value="Pérez" />
                        <select class="w-full p-2 border rounded">
                            <option>Cajero</option>
                            <option selected>Administrador</option>
                        </select>
                        <input type="number" placeholder="Nuevo salario" class="w-full p-2 border rounded"
                            value="4000" />
                        <button class="w-full bg-yellow-500 text-white py-2 rounded hover:bg-yellow-600">Actualizar</button>
                    </form>
                </div>

                <!-- Eliminar / Desactivar -->
                <div class="bg-white p-5 rounded-lg shadow-md">
                    <h3 class="font-bold mb-3">🗑️ Eliminar / Desactivar</h3>
                    <form class="space-y-3">
                        <select class="w-full p-2 border rounded">
                            <option disabled selected>Seleccionar usuario</option>
                            <option>Juan Pérez</option>
                            <option>María Gómez</option>
                        </select>
                        <div class="flex space-x-2">
                            <button class="flex-1 bg-red-500 text-white py-2 rounded hover:bg-red-600">Eliminar</button>
                            <button class="flex-1 bg-gray-500 text-white py-2 rounded hover:bg-gray-600">Desactivar</button>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">* Eliminar borra permanentemente. Desactivar lo mantiene
                            en el
                            sistema.</p>
                    </form>
                </div>
            </div>
        </section>

        <!-- Sección 3: Roles y Permisos -->
        <section class="mb-10">
            <h2 class="text-2xl font-bold mb-4 text-indigo-800 border-b pb-2">🔐 Roles y Permisos</h2>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="font-bold mb-4">Definir permisos por rol</h3>
                <div class="space-y-4">
                    <!-- Ejemplo: Administrador -->
                    <div class="border p-4 rounded">
                        <h4 class="font-semibold text-indigo-700">Administrador</h4>
                        <p class="text-sm text-gray-600">Puede hacer todo: gestionar usuarios, roles, productos,
                            ventas,
                            sueldos, etc.</p>
                    </div>
                    <!-- Cajero -->
                    <div class="border p-4 rounded">
                        <h4 class="font-semibold text-green-700">Cajero</h4>
                        <p class="text-sm text-gray-600">Registrar ventas y ver su historial. Sin acceso a gestión de
                            usuarios o productos.</p>
                    </div>
                    <!-- Vendedor -->
                    <div class="border p-4 rounded">
                        <h4 class="font-semibold text-blue-700">Vendedor</h4>
                        <p class="text-sm text-gray-600">Ver productos y registrar ventas. Sin acceso a caja completa o
                            reportes financieros.</p>
                    </div>
                </div>
                <div class="mt-6">
                    <h4 class="font-semibold mb-2">➕ Crear Rol Personalizado</h4>
                    <input type="text" placeholder="Nombre del rol" class="w-full p-2 border rounded mb-2" />
                    <div class="space-y-2 text-sm">
                        <label class="flex items-center">
                            <input type="checkbox" class="mr-2" /> Gestionar usuarios
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="mr-2" /> Registrar ventas
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="mr-2" /> Ver reportes
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="mr-2" /> Gestionar productos
                        </label>
                    </div>
                    <button class="mt-3 bg-purple-600 text-white py-2 px-4 rounded hover:bg-purple-700">Crear
                        Rol</button>
                </div>
            </div>
        </section>

        <!-- Sección 4: Visualización de Sueldos -->
        <section class="mb-10">
            <h2 class="text-2xl font-bold mb-4 text-indigo-800 border-b pb-2">💰 Sueldos</h2>
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
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Rol</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Sueldo</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Fecha Pago
                                </th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr>
                                <td class="px-4 py-3">Juan Pérez</td>
                                <td class="px-4 py-3">Administrador</td>
                                <td class="px-4 py-3">$4,000</td>
                                <td class="px-4 py-3">01/04/2025</td>
                                <td class="px-4 py-3">
                                    <button class="text-blue-600 hover:underline text-sm">Ver recibo</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3">Ana López</td>
                                <td class="px-4 py-3">Cajero</td>
                                <td class="px-4 py-3">$1,200</td>
                                <td class="px-4 py-3">01/04/2025</td>
                                <td class="px-4 py-3">
                                    <button class="text-blue-600 hover:underline text-sm">Ver recibo</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- Sección 5: Actividad y Auditoría -->
        <section class="mb-10">
            <h2 class="text-2xl font-bold mb-4 text-indigo-800 border-b pb-2">📋 Actividad y Auditoría</h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Últimos accesos -->
                <div class="bg-white p-5 rounded-lg shadow-md">
                    <h3 class="font-bold mb-3">🚪 Últimos Accesos</h3>
                    <ul class="space-y-2 text-sm">
                        <li><strong>Juan Pérez</strong> - hace 2 horas</li>
                        <li><strong>Ana López</strong> - hace 4 horas</li>
                        <li><strong>Carlos Ruiz</strong> - ayer</li>
                        <li><strong>Lucía Méndez</strong> - hace 3 días</li>
                    </ul>
                </div>
                <!-- Últimas acciones -->
                <div class="bg-white p-5 rounded-lg shadow-md">
                    <h3 class="font-bold mb-3">📝 Últimas Acciones</h3>
                    <ul class="space-y-2 text-sm">
                        <li><strong>Registro de venta</strong> por Ana López - ID #1023</li>
                        <li><strong>Edición de producto</strong> por Juan Pérez - “Laptop XYZ”</li>
                        <li><strong>Nuevo usuario creado</strong> por Admin - “Carlos Ruiz”</li>
                        <li><strong>Reporte descargado</strong> por Lucía Méndez</li>
                    </ul>
                </div>
            </div>
            <div class="mt-6 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <span class="h-5 w-5 text-yellow-500 font-bold">⚠️</span>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-800">
                            <strong>Alerta:</strong> 3 intentos fallidos de inicio de sesión para
                            “carlos.ruiz@email.com”.
                            <a href="#" class="underline ml-1">Investigar</a>
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Sección 6: Opciones de Seguridad -->
        <section class="mb-10">
            <h2 class="text-2xl font-bold mb-4 text-indigo-800 border-b pb-2">🔒 Seguridad</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-5 rounded-lg shadow-md">
                    <h3 class="font-bold mb-2">🔑 Cambiar Contraseña</h3>
                    <form class="space-y-2">
                        <input type="password" placeholder="Contraseña actual" class="w-full p-2 border rounded" />
                        <input type="password" placeholder="Nueva contraseña" class="w-full p-2 border rounded" />
                        <input type="password" placeholder="Confirmar nueva" class="w-full p-2 border rounded" />
                        <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Guardar
                            Cambios</button>
                    </form>
                </div>
                <div class="bg-white p-5 rounded-lg shadow-md">
                    <h3 class="font-bold mb-2">🔄 Restablecer Contraseña (Admin)</h3>
                    <form class="space-y-2">
                        <select class="w-full p-2 border rounded">
                            <option disabled selected>Seleccionar usuario</option>
                            <option>Juan Pérez</option>
                            <option>Ana López</option>
                        </select>
                        <button
                            class="w-full bg-orange-500 text-white py-2 rounded hover:bg-orange-600">Restablecer</button>
                        <p class="text-xs text-gray-500">Se enviará un enlace temporal al email del usuario.</p>
                    </form>
                </div>
                <div class="bg-white p-5 rounded-lg shadow-md">
                    <h3 class="font-bold mb-2">⛔ Bloqueo Temporal</h3>
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
    </div>

@endsection
