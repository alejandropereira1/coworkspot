<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $espacio->nombre }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                {{-- Imagen del espacio (si tiene) --}}
                @if($espacio->image)
                    <div class="mb-4">
                        <img src="{{ filter_var($espacio->image, FILTER_VALIDATE_URL) ? $espacio->image : asset('storage/' . $espacio->image) }}" 
                             alt="{{ $espacio->nombre }}" 
                             class="w-full h-64 object-cover rounded-lg">
                    </div>
                @endif

                <h3 class="text-2xl font-bold mb-4">{{ $espacio->nombre }}</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <p><strong>Tipo:</strong> {{ $espacio->tipo->nombre }}</p>
                        <p><strong>Capacidad:</strong> {{ $espacio->capacidad }} persona(s)</p>
                        <p><strong>Piso:</strong> {{ $espacio->piso ?? 'No especificado' }}</p>
                        <p><strong>Precio:</strong> ${{ number_format($espacio->precio_por_hora, 0) }} COP/hora</p>
                    </div>
                    <div>
                        <p><strong>Estado:</strong> 
                            <span class="px-2 py-1 text-xs rounded-full {{ $espacio->activo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $espacio->activo ? 'Disponible' : 'No disponible' }}
                            </span>
                        </p>
                    </div>
                </div>

                <div class="mt-4">
                    <strong>Comodidades:</strong>
                    @if($espacio->comodidades->count() > 0)
                        <ul class="list-disc list-inside mt-2">
                            @foreach ($espacio->comodidades as $comodidad)
                                <li>{{ $comodidad->nombre }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500 text-sm mt-1">Este espacio no tiene comodidades registradas.</p>
                    @endif
                </div>

                {{-- Zona de reserva (solo si está autenticado) --}}
                @auth
                    <div class="mt-6 border-t pt-6">
                        <h4 class="text-lg font-semibold mb-3">Reservar este espacio</h4>
                        
                        {{-- Botón directo a reserva --}}
                        <a href="{{ route('reservas.create', $espacio) }}" 
                           class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-6 rounded-lg shadow-md transition">
                            Reservar ahora
                        </a>

                        {{-- Formulario de disponibilidad (opcional) --}}
                        <div class="mt-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <h5 class="font-medium text-sm text-gray-700 mb-2">Consultar disponibilidad por fecha</h5>
                            <form action="{{ route('espacios.disponibilidad', $espacio) }}" method="POST" class="flex flex-wrap items-end gap-4">
                                @csrf
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Fecha</label>
                                    <input type="date" name="fecha" min="{{ date('Y-m-d') }}" required
                                           class="border rounded-lg p-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                                <button type="submit"
                                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition">
                                    Consultar
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="mt-6 border-t pt-6">
                        <p class="text-gray-600">
                            <a href="{{ route('login') }}" class="text-blue-500 hover:underline font-medium">Inicia sesión</a> 
                            para reservar este espacio.
                        </p>
                        <p class="text-sm text-gray-500 mt-1">
                            ¿No tienes cuenta? <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Regístrate aquí</a>.
                        </p>
                    </div>
                @endauth

                <div class="mt-6 pt-4 border-t border-gray-200">
                    <a href="{{ route('inicio') }}" class="text-blue-500 hover:text-blue-700 transition">
                        ← Volver al listado de espacios
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>