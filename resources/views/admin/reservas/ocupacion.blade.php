<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ocupación general por espacio
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @forelse($espacios as $espacio)
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <h3 class="font-bold text-lg">{{ $espacio->nombre }}</h3>
                                <p class="text-sm text-gray-600">Tipo: {{ $espacio->tipo->nombre ?? 'N/A' }}</p>
                                <p class="text-sm text-gray-600">Capacidad: {{ $espacio->capacidad }}</p>
                                <p class="text-sm text-gray-600">Precio/h: ${{ number_format($espacio->precio_por_hora, 0, ',', '.') }}</p>
                                <div class="mt-2 p-2 bg-white rounded border border-gray-200">
                                    <p class="text-sm font-medium">
                                        Reservas hoy: 
                                        <span class="text-indigo-600 font-bold">{{ $espacio->reservas_hoy ?? 0 }}</span>
                                    </p>
                                    <p class="text-sm font-medium">
                                        Reservas pendientes: 
                                        <span class="text-yellow-600 font-bold">{{ $espacio->reservas_pendientes ?? 0 }}</span>
                                    </p>
                                    <p class="text-sm font-medium">
                                        Reservas confirmadas: 
                                        <span class="text-green-600 font-bold">{{ $espacio->reservas_confirmadas ?? 0 }}</span>
                                    </p>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 col-span-full text-center">No hay espacios registrados.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>