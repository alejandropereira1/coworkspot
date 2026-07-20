<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Crear nuevo espacio
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.espacios.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nombre</label>
                                <input type="text" name="nombre" value="{{ old('nombre') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                @error('nombre') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tipo</label>
                                <select name="tipo_espacio_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    @foreach($tipos as $tipo)
                                        <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                    @endforeach
                                </select>
                                @error('tipo_espacio_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Capacidad</label>
                                <input type="number" name="capacidad" value="{{ old('capacidad', 1) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                @error('capacidad') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Precio por hora (COP)</label>
                                <input type="number" step="0.01" name="precio_por_hora" value="{{ old('precio_por_hora') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                @error('precio_por_hora') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Piso</label>
                                <input type="number" name="piso" value="{{ old('piso') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                @error('piso') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" name="activo" value="1" {{ old('activo', true) ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                <label class="ml-2 block text-sm text-gray-700">Activo</label>
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700">Imagen</label>
                            <input type="file" name="image" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            @error('image') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700">Comodidades</label>
                            <select name="comodidades[]" multiple class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" size="4">
                                @foreach($comodidades as $comodidad)
                                    <option value="{{ $comodidad->id }}">{{ $comodidad->nombre }}</option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 mt-1">Mantén presionado Ctrl para seleccionar múltiples.</p>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <a href="{{ route('admin.espacios.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Cancelar</a>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>