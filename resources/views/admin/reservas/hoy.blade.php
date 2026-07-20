<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Reservas del día
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if(session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if($reservas->isEmpty())
                        <p class="text-gray-500">No hay reservas para hoy.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Espacio</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Usuario</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Horario</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($reservas as $reserva)
                                    <tr>
                                        <td class="px-6 py-4">{{ $reserva->espacio->nombre }}</td>
                                        <td class="px-6 py-4">{{ $reserva->user->name }}</td>
                                        <td class="px-6 py-4">{{ $reserva->hora_inicio }} - {{ $reserva->hora_fin }}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 py-1 text-xs rounded-full 
                                                @if($reserva->estado == 'pendiente') bg-yellow-100 text-yellow-800
                                                @elseif($reserva->estado == 'confirmada') bg-green-100 text-green-800
                                                @else bg-red-100 text-red-800 @endif">
                                                {{ ucfirst($reserva->estado) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 flex space-x-2">
                                            @if($reserva->estado == 'pendiente')
                                                <form method="POST" action="{{ route('admin.reservas.confirmar', $reserva) }}">
                                                    @csrf
                                                    <button type="submit" class="text-green-600 hover:text-green-900 font-medium">Confirmar</button>
                                                </form>
                                            @endif
                                            @if(in_array($reserva->estado, ['pendiente', 'confirmada']))
                                                <form method="POST" action="{{ route('admin.reservas.cancelar', $reserva) }}" onsubmit="return confirm('¿Cancelar esta reserva?')">
                                                    @csrf
                                                    <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Cancelar</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>