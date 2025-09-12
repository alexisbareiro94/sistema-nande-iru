@extends('layouts.app')
@section('ruta-anterior', 'Inventario')
@section('url', '/inventario')
@section('ruta-actual', 'Edicion de producto')
@section('titulo', "Editar $producto->nombre")

@section('contenido')
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4 p-6">
        <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
            </svg>

            Edicion de: {{ $producto->nombre }}
        </h1>
    </div>
    <div class="max-w-full mx-auto bg-white rounded-2xl shadow-md overflow-hidden mt-2">
        <form id="form-add-producto-u" action="" method="POST" enctype="multipart/form-data" class="p-6 space-y-8">
            <!-- Sección de Información Básica -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <input type="hidden" id="producto_id" name="producto_id" value="{{ $producto->id ?? '' }}">
                <!-- Nombre -->
                <div class="md:col-span-2">
                    <label for="nombre" class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Nombre del Producto:
                    </label>
                    <input type="text" name="nombre" id="nombre" placeholder="Escribe el nuevo nombre"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-gray-700 focus:border-gray-700 transition-all duration-200">
                    <p class="text-xs text-gray-500 mt-1">
                        Nombre Actual: <span class="font-semibold underline">{{ $producto->nombre ?? 'Sin Nombre' }}</span>
                    </p>
                </div>

                <div class="md:col-span-2">
                    <label for="codigo" class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Código de Producto:
                    </label>
                    <input type="text" name="codigo" id="codigo" value="" placeholder="Escribe el nuevo codigo"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-gray-700 focus:border-gray-700">
                    <p class="text-xs text-gray-500 mt-1">
                        Código Actual: <span class="font-semibold underline">{{ $producto->codigo ?? 'Sin Codigo' }}</span>
                    </p>
                </div>

                <!-- Categoría -->
                <div>
                    <label for="categoria_id" class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Categoría:
                    </label>
                    <div class="flex">
                        <select name="categoria_id" id="categoria_id"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-l-xl focus:ring-2 focus:ring-gray-700 focus:border-gray-700 appearance-none bg-white">
                            <option value="">Seleccionar nueva categoría</option>
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}">
                                    {{ $categoria->nombre }}
                                </option>
                            @endforeach
                        </select>

                        <span id="add-categoria" class="px-3 py-3 bg-gray-700 text-white rounded-r-xl cursor-pointer">
                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">
                        Categoría Actual: <span
                            class="font-semibold underline">{{ $producto->categoria->nombre ?? 'Sin Categoria' }}</span>
                    </p>
                </div>
                <!-- marcas -->
                <div>
                    <label for="marca_id" class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Marca:
                    </label>
                    <div class="flex">
                        <select name="marca_id" id="marca_id"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-l-xl focus:ring-2 focus:ring-gray-700 focus:border-gray-700 appearance-none bg-white">
                            <option value="">Seleccionar nueva marca</option>
                            @foreach ($marcas as $marca)
                                <option value="{{ $marca->id }}">
                                    {{ $marca->nombre }}
                                </option>
                            @endforeach
                        </select>

                        <span id="add-marca" class="px-3 py-3 bg-gray-700 text-white rounded-r-xl cursor-pointer">
                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">
                        Marca Actual: <span class="font-semibold underline">{{ $producto->marca->nombre ?? 'Sin Marca' }}</span>
                    </p>
                </div>
            </div>

            <!-- Distribuidor -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="distribuidor_id" class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Distribuidor:
                    </label>
                    <div class="flex">
                        <select name="distribuidor_id" id="distribuidor_id"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-l-xl focus:ring-2 focus:ring-gray-700 focus:border-gray-700 appearance-none bg-white">
                            <option value="">Seleccionar nuevo Distribuidor</option>
                            @foreach ($distribuidores as $distribudor)
                                <option value="{{ $distribudor->id }}">
                                    {{ $distribudor->nombre }}
                                </option>
                            @endforeach
                        </select>

                        <span id="add-distribuidor" class="px-3 py-3 bg-gray-700 text-white rounded-r-xl cursor-pointer">
                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">
                        Distribuidor Actual: <span
                            class="font-semibold underline">{{ $producto->distribuidor->nombre ?? 'Sin Distribuidor' }}</span>
                    </p>
                </div>

                {{-- tipo de producto --}}
                <div class="justify-center gap-2 my-2">
                    <label for="tipo-e" class="block text-sm font-semibold text-gray-700 mb-1">
                        Tipo de Producto:
                    </label>
                    <div class="flex gap-0.5 text-center">
                        <select name="tipo-e" id="tipo-e"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-gray-700 focus:border-gray-700 appearance-none bg-white">
                            <option value="">Seleccionar nuevo Tipo de producto</option>
                            <option value="servicio">Servicio</option>
                            <option value="producto">Producto</option>
                        </select>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">
                        Distribuidor Actual: <span class="font-semibold underline">{{ $producto->tipo ?? '' }}</span>
                    </p>
                </div>
            </div>
            <!-- Descripción -->
            <div class="md:col-span-2">
                <label for="descripcion" class="block text-sm font-semibold text-gray-700 mb-1.5">
                    Descripción Detallada:
                </label>
                <textarea name="descripcion" id="descripcion" rows="3"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-gray-700 focus:border-gray-700"
                    placeholder="Describe las características principales del producto...">{{ $producto->descripcion ?? '' }}</textarea>

                @if (empty($producto->descripcion))
                    <p class="text-xs text-gray-500 mt-1">
                        Descripción Actual: <span
                            class="font-semibold underline">{{ $producto->descripcion ?? 'Sin Descripción' }}</span>
                    </p>
                @endif
            </div>

            <!-- Sección de Precios y Stock -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Precios -->
                <div class="space-y-6 bg-gray-50 p-5 rounded-xl">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2 border-b pb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M12 7c1.11 0 2.08.402 2.599 1" />
                        </svg>
                        Configuración de Precios
                    </h2>

                    {{-- precio compra  --}}
                    <div>
                        <label for="precio_compra" class="block text-sm font-medium text-gray-700 mb-1">
                            Precio de Compra (GS.):
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm mr-1">GS.</span>
                            </div>
                            <input type="number" name="precio_compra" id="precio_compra" value=""
                                class="w-full pl-8 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-gray-700 focus:border-gray-700"
                                placeholder="0.00">
                        </div>
                        <p class="text-xs text-gray-500 mt-1">
                            Precio compra actual Gs.: <span
                                class="font-semibold underline">{{ number_format($producto->precio_compra, 0, ',', '.') ?? 0 }}</span>
                        </p>
                    </div>

                    {{-- precio venta --}}
                    <div>
                        <label for="precio_venta" class="block text-sm font-medium text-gray-700 mb-1">
                            Precio de Venta (GS.)
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">GS.</span>
                            </div>
                            <input type="number" name="precio_venta" id="precio_venta" value=""
                                class="w-full pl-8 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-gray-700 focus:border-gray-700"
                                placeholder="0.00">
                        </div>
                        <p class="text-xs text-gray-500 mt-1">
                            Categoría venta actual Gs.: <span
                                class="font-semibold underline">{{ number_format($producto->precio_venta, 0, ',', '.') ?? 0 }}</span>
                        </p>
                    </div>
                </div>

                <!-- Stock -->
                <div class="space-y-6 bg-gray-50 p-5 rounded-xl">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2 border-b pb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        Gestión de Stock
                    </h2>

                    {{-- stock disponible --}}
                    <div>
                        <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">
                            Cantidad en Stock:
                            {{-- <span
                                class="text-lg px-2 py-1 bg-gray-300 rounded-md">{{ number_format($producto->stock, 0, ',', '.') }}</span> --}}
                        </label>
                        <input type="number" name="stock" id="stock" value=""
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-gray-700 focus:border-gray-700"
                            placeholder="0">

                        @if ($producto->tipo == 'servicio')
                            <p class="text-xs text-gray-500 mt-1">
                                <span class="font-semibold underline">Servicio</span>
                            </p>
                        @else
                            <p class="text-xs text-gray-500 mt-1">
                                Stock Actual: <span class="font-semibold underline">{{ $producto->stock }}</span>
                            </p>
                        @endif
                    </div>

                    {{-- stock minimo --}}
                    <div>
                        <label for="stock_minimo" class="block text-sm font-medium text-gray-700 mb-1">
                            Stock Mínimo:
                        </label>
                        <input type="number" name="stock_minimo" id="stock_minimo" value=""
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-gray-700 focus:border-gray-700"
                            placeholder="4">
                        @if ($producto->tipo == 'servicio')
                            <p class="text-xs text-gray-500 mt-1">
                                <span class="font-semibold underline">Servicio</span>
                            </p>
                        @else
                            <p class="text-xs text-gray-500 mt-1">
                                Stock Mínimo: <span class="font-semibold underline">{{ $producto->stock_minimo }}</span>
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sección de Imagen -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Imagen del Producto
                </label>
                <div
                    class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-gray-700 transition-colors duration-300">

                    {{-- seleccionar una imagen --}}
                    <div id="div-img-original-u" @class([
                        'space-y-2 text-center',
                        'hidden' => $producto->imagen != null,
                    ])>
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                            viewBox="0 0 48 48" aria-hidden="true">
                            <path
                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600">
                            <label for="imagen"
                                class="relative cursor-pointer bg-gray-700 hover:bg-yellow-500 rounded-lg font-medium text-white py-2 px-4 transition-colors">
                                <span>Seleccionar imagen</span>
                                <input id="imagen" name="imagen" type="file" class="sr-only" accept="image/*">
                            </label>
                            <p class="pl-1 self-center text-gray-500">o arrastrar y soltar</p>
                        </div>
                        <p class="text-xs text-gray-500">PNG, JPG, GIF hasta 5MB</p>
                    </div>

                    {{-- {{$imagePreview}} --}}
                    <div id="preview-cont-u" @class(['relative', 'hidden' => $producto->imagen == null])>
                        {{-- alerta de borrado --}}
                        <div id="alerta-borrado"
                            class="hidden absolute z-30 w-full h-full bg-red-500/40 inset-0 pt-10 text-center items-center">

                            <p class="text-white font-bold bg-red-400 inline-block px-2 py-1 rounded-md">
                                Eliminar Imagen?
                            </p>
                            <div class="flex justify-center gap-2 mt-2">
                                <button id="confirmar-borrado" type="button"
                                    class="bg-green-400 px-2 py-1 font-semibold rounded-md cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                    </svg>
                                </button>

                                <button id="cancelar-borrado" type="button"
                                    class="bg-red-400 px-2 py-1 font-semibold rounded-md cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- boton para eliminar --}}
                        @if (filled($producto->imagen))
                            <!-- realmente cierra la alerta para borrar la imagen -->
                            <span id="cerrar-preview-u"
                                class="absolute z-20 right-0 px-1 py-1 cursor-pointer transition-all duration-150 bg-red-400 rounded-lg hover:bg-red-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>

                            </span>
                        @else
                            <!-- este si cierra la preview -->
                            <span id="cerrar-preview-up"
                                class="absolute z-20 right-0 px-1 cursor-pointer transition-all duration-150 bg-red-500/20 rounded-lg hover:bg-green-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                </svg>
                            </span>
                        @endif
                        <div class="z-10">
                            <img id="imagen-preview-u" class="max-w-54"
                                src="{{ asset("images/$producto->imagen") ?? '' }}">
                        </div>
                    </div>

                </div>
            </div>
            <!-- Botón de Envío -->
            <div class="flex justify-end pt-4 border-t">
                <button type="button" id="boton-u"
                    class="group bg-gradient-to-r from-gray-700 to-yellow-500 hover:from-yellow-500 hover:to-gray-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform transition-all duration-300 hover:shadow-xl hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-700">
                    <span class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:scale-110 transition-transform"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                        </svg>
                        Confirmar Cambios
                    </span>
                </button>
            </div>
        </form>
    </div>

    @include('productos.includes.add-distribuidor')
    @include('productos.includes.add-categoria')
    @include('productos.includes.add-marca')
@endsection
