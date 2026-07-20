<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Reservar: {{ $espacio->nombre }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($errors->any())
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('reservas.store') }}">
                        @csrf
                        <input type="hidden" name="espacio_id" value="{{ $espacio->id }}">

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Fecha</label>
                            <input type="date" name="fecha" value="{{ old('fecha') }}" min="{{ date('Y-m-d') }}" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            @error('fecha') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4 grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Hora inicio</label>
                                <input type="time" name="hora_inicio" value="{{ old('hora_inicio') }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                @error('hora_inicio') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Hora fin</label>
                                <input type="time" name="hora_fin" value="{{ old('hora_fin') }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                @error('hora_fin') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <p class="text-sm text-gray-600">Precio por hora: <strong>${{ number_format($espacio->precio_por_hora, 0, ',', '.') }}</strong></p>
                            <p class="text-sm text-gray-600">Capacidad: <strong>{{ $espacio->capacidad }} personas</strong></p>
                        </div>

                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg">
                            Confirmar reserva
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>