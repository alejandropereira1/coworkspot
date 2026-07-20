<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tipos de espacio</h2>
            <a href="{{ route('admin.tipos-espacio.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg">+ Nuevo tipo</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">{{ session('success') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Descripción</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Espacios</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($tipos as $tipo)
                            <tr>
                                <td class="px-6 py-4">{{ $tipo->nombre }}</td>
                                <td class="px-6 py-4">{{ $tipo->descripcion ?? '-' }}</td>
                                <td class="px-6 py-4">{{ $tipo->espacios_count ?? 0 }}</td>
                                <td class="px-6 py-4 flex gap-2">
                                    <a href="{{ route('admin.tipos-espacio.edit', $tipo) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                    <form method="POST" action="{{ route('admin.tipos-espacio.destroy', $tipo) }}" onsubmit="return confirm('¿Eliminar este tipo?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>