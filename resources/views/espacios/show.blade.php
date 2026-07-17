<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $espacio->nombre }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <p><strong>Tipo:</strong> {{ $espacio->tipo->nombre }}</p>
                <p><strong>Capacidad:</strong> {{ $espacio->capacidad }} persona(s)</p>
                <p><strong>Piso:</strong> {{ $espacio->piso ?? 'No especificado' }}</p>
                <p><strong>Precio:</strong> ${{ number_format($espacio->precio_por_hora, 0) }} COP/hora</p>

                <div class="mt-4">
                    <strong>Comodidades:</strong>
                    <ul class="list-disc list-inside">
                        @foreach ($espacio->comodidades as $comodidad)
                            <li>{{ $comodidad->nombre }}</li>
                        @endforeach
                    </ul>
                </div>

                @auth
                    <div class="mt-6">
                        <h4 class="text-lg font-semibold mb-3">Buscar disponibilidad</h4>
                        <form action="{{ route('espacios.disponibilidad', $espacio) }}" method="POST">
                            @csrf
                            <div class="flex items-end gap-4">
                                <div>
                                    <label class="block text-sm mb-1">Fecha</label>
                                    <input type="date" name="fecha" min="{{ date('Y-m-d') }}" required
                                           class="border rounded p-2">
                                </div>
                                <button type="submit"
                                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                    Consultar
                                </button>
                            </div>
                        </form>
                    </div>
                @else
                    <p class="mt-6">
                        <a href="{{ route('login') }}" class="text-blue-500 underline">Inicia sesión</a> para reservar.
                    </p>
                @endauth

                <a href="{{ route('inicio') }}" class="mt-4 inline-block text-blue-500">← Volver al listado</a>
            </div>
        </div>
    </div>
</x-app-layout>