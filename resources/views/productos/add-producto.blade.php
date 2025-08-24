@extends('layouts.app')

@section('titulo', 'Agregar Producto')

@section('contenido')
    <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden mt-2">
        <div class="bg-gradient-to-r from-amarillo to-yellow-500 p-6">
            <h1 class="text-2xl font-bold text-white flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Agregar Nuevo Producto
            </h1>
        </div>

        <form id="form-add-producto" action="" method="POST" enctype="multipart/form-data" class="p-6 space-y-8">
            <!-- Sección de Información Básica -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nombre -->
                <div class="md:col-span-2">
                    <label for="nombre" class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Nombre del Producto <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amarillo focus:border-amarillo transition-all duration-200"
                        placeholder="Ej: Cubierta 195/65R15">
                </div>
                <div class="md:col-span-2">
                    <label for="codigo" class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Código de Producto <span class="text-red-500">*</span>
                    </label>
                    <div class="flex">
                        <input type="text" name="codigo" id="codigo" value="{{ old('codigo') }}"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amarillo focus:border-amarillo"
                            placeholder="Ej: cub-1956515-ll">
                        <label for="codigo-auto" class="flex items-center cursor-pointer mx-2">
                            <!-- Toggle -->
                            <div class="relative">
                                <input type="checkbox" id="codigo-auto" name="codigo-auto" class="sr-only">
                                <div class="block bg-gray-300 w-14 h-8 rounded-full"></div>
                                <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition"></div>
                            </div>                           
                            <span id="switch" class="ml-3 text-gray-700 text-xs font-medium">código automático</span>
                        </label>                                              
                    </div>
                </div>

                <!-- Categoría -->
                <div>
                    <label for="categoria_id" class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Categoría <span class="text-red-500">*</span>
                    </label>
                    <div class="flex">
                        <select name="categoria_id" id="categoria_id"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-l-xl focus:ring-2 focus:ring-amarillo focus:border-amarillo appearance-none bg-white">
                            <option value="">Seleccionar categoría</option>
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}"
                                    {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                    {{ $categoria->nombre }}
                                </option>
                            @endforeach
                        </select>

                        <span id="add-categoria" class="px-3 py-3 bg-amarillo rounded-r-xl cursor-pointer">
                            +
                        </span>
                    </div>
                </div>
                <!-- marcas -->
                <div>
                    <label for="marca_id" class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Marcas
                    </label>
                    <div class="flex">
                        <select name="marca_id" id="marca_id"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-l-xl focus:ring-2 focus:ring-amarillo focus:border-amarillo appearance-none bg-white">
                            <option value="">Seleccionar marca</option>
                            @foreach ($marcas as $marca)
                                <option value="{{ $marca->id }}" {{ old('marca_id') == $marca->id ? 'selected' : '' }}>
                                    {{ $marca->nombre }}
                                </option>
                            @endforeach
                        </select>

                        <span id="add-marca" class="px-3 py-3 bg-amarillo rounded-r-xl cursor-pointer">
                            +
                        </span>
                    </div>
                </div>
            </div>

            <!-- Distribuidor -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="distribuidor_id" class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Distribuidor
                    </label>
                    <div class="flex">
                        <select name="distribuidor_id" id="distribuidor_id"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-l-xl focus:ring-2 focus:ring-amarillo focus:border-amarillo appearance-none bg-white">
                            <option value="">Seleccionar Distribuidor</option>
                            @foreach ($distribuidores as $distribudor)
                                <option value="{{ $distribudor->id }}"
                                    {{ old('marca_id') == $distribudor->id ? 'selected' : '' }}>
                                    {{ $distribudor->nombre }}
                                </option>
                            @endforeach
                        </select>

                        <span id="add-distribuidor" class="px-3 py-3 bg-amarillo rounded-r-xl cursor-pointer">
                            +
                        </span>
                    </div>
                </div>

                <div class="justify-center gap-2 my-2">
                    <label for="distribuidor_id" class="block text-sm font-semibold text-gray-700 mb-1">
                        Tipo de Producto
                    </label>
                    <div class="flex gap-0.5 text-center">
                        <label id="l-producto"
                            class="flex-1 max-w-xs p-1 border-2 border-gris bg-amarillo rounded-lg cursor-pointer transition flex flex-col">
                            <div class="flex items-center mb-2">
                                <input checked id="radio-producto" type="radio" name="tipo-producto" value="producto"
                                    class="sr-only" />
                                <span class="text-negro font-black">Producto</span>
                            </div>
                        </label>

                        <label id="l-servicio"
                            class="flex-1 max-w-xs p-1 border-2 border-gris rounded-lg cursor-pointer transition flex flex-col">
                            <div class="flex items-center mb-2">
                                <input id="radio-servicio" type="radio" name="tipo-producto" value="servicio"
                                    class="sr-only" />
                                <span class="font-semibold text-negro">Servicio</span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
            <!-- Descripción -->
            <div class="md:col-span-2">
                <label for="descripcion" class="block text-sm font-semibold text-gray-700 mb-1.5">
                    Descripción Detallada
                </label>
                <textarea name="descripcion" id="descripcion" rows="3"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amarillo focus:border-amarillo"
                    placeholder="Describe las características principales del producto...">{{ old('descripcion') }}</textarea>
            </div>

            <!-- Sección de Precios y Stock -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Precios -->
                <div class="space-y-6 bg-gray-50 p-5 rounded-xl">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2 border-b pb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amarillo" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M12 7c1.11 0 2.08.402 2.599 1" />
                        </svg>
                        Configuración de Precios
                    </h2>

                    <div>
                        <label for="precio_compra" class="block text-sm font-medium text-gray-700 mb-1">
                            Precio de Compra (GS.)
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">Gs.</span>
                            </div>
                            <input type="number" step="0.01" name="precio_compra" id="precio_compra"
                                value="{{ old('precio_compra') }}"
                                class="w-full pl-8 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amarillo focus:border-amarillo"
                                placeholder="0.00">
                        </div>
                    </div>

                    <div>
                        <label for="precio_venta" class="block text-sm font-medium text-gray-700 mb-1">
                            Precio de Venta (GS.) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">Gs.</span>
                            </div>
                            <input type="number" step="0.01" name="precio_venta" id="precio_venta"
                                value="{{ old('precio_venta') }}"
                                class="w-full pl-8 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amarillo focus:border-amarillo"
                                placeholder="0.00">
                        </div>
                    </div>
                </div>

                <!-- Stock -->
                <div class="space-y-6 bg-gray-50 p-5 rounded-xl">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2 border-b pb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amarillo" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        Gestión de Stock
                    </h2>

                    <div>
                        <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">
                            Cantidad en Stock <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="stock" id="stock" value="{{ old('stock') }}"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amarillo focus:border-amarillo"
                            placeholder="0">
                    </div>

                    <div>
                        <label for="stock_minimo" class="block text-sm font-medium text-gray-700 mb-1">
                            Stock Mínimo
                        </label>
                        <input type="number" name="stock_minimo" id="stock_minimo" value="{{ old('stock_minimo') }}"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amarillo focus:border-amarillo"
                            placeholder="5">
                    </div>
                </div>
            </div>

            <!-- Sección de Imagen -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Imagen del Producto
                </label>
                <div
                    class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-amarillo transition-colors duration-300">

                    <div id="div-img-original" class="space-y-2 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                            viewBox="0 0 48 48" aria-hidden="true">
                            <path
                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600">
                            <label for="imagen"
                                class="relative cursor-pointer bg-amarillo hover:bg-yellow-500 rounded-lg font-medium text-white py-2 px-4 transition-colors">
                                <span>Seleccionar imagen</span>
                                <input id="imagen" name="imagen" type="file" class="sr-only" accept="image/*">
                            </label>
                            <p class="pl-1 self-center text-gray-500">o arrastrar y soltar</p>
                        </div>
                        <p class="text-xs text-gray-500">PNG, JPG, GIF hasta 5MB</p>
                    </div>

                    <div id="preview-cont" class="relative hidden">
                        <span id="cerrar-preview"
                            class="absolute z-20 right-0 px-1 cursor-pointer transition-all duration-150 bg-red-500/20 rounded-lg hover:bg-red-500">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </span>
                        <div class="z-10">
                            <img id="imagen-preview" class="max-w-54" src="">
                        </div>
                    </div>

                    {{-- {{$imagePreview}} --}}
                </div>
            </div>

            <!-- Botón de Envío -->
            <div class="flex justify-end pt-4 border-t">
                <button type="button" id="boton"
                    class="group bg-gradient-to-r from-amarillo to-yellow-500 hover:from-yellow-500 hover:to-amarillo text-white font-bold py-3 px-8 rounded-xl shadow-lg transform transition-all duration-300 hover:shadow-xl hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amarillo">
                    <span class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:scale-110 transition-transform"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                        </svg>
                        Guardar Producto
                    </span>
                </button>
            </div>
        </form>
    </div>
    @include('productos.includes.add-distribuidor')
    @include('productos.includes.add-categoria')
    @include('productos.includes.add-marca')    
@endsection
