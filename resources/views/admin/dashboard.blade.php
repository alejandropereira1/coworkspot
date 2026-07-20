<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Panel de Administración
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Tarjetas de estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Espacios totales</div>
                    <div class="text-2xl font-bold">{{ $totalEspacios ?? 0 }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Reservas hoy</div>
                    <div class="text-2xl font-bold">{{ $totalReservasHoy ?? 0 }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Usuarios registrados</div>
                    <div class="text-2xl font-bold">{{ $totalUsuarios ?? 0 }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Reservas pendientes</div>
                    <div class="text-2xl font-bold">{{ $reservasPendientes ?? 0 }}</div>
                </div>
            </div>

            <!-- Reservas recientes -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Reservas recientes</h3>
                    @if(isset($reservasRecientes) && $reservasRecientes->isEmpty())
                        <p class="text-gray-500">No hay reservas recientes.</p>
                    @elseif(isset($reservasRecientes))
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Espacio</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Usuario</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Horario</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($reservasRecientes as $reserva)
                                    <tr>
                                        <td class="px-6 py-4">{{ $reserva->espacio->nombre ?? 'N/A' }}</td>
                                        <td class="px-6 py-4">{{ $reserva->user->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($reserva->fecha)->format('d/m/Y') }}</td>
                                        <td class="px-6 py-4">{{ $reserva->hora_inicio }} - {{ $reserva->hora_fin }}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 py-1 text-xs rounded-full 
                                                @if($reserva->estado == 'pendiente') bg-yellow-100 text-yellow-800
                                                @elseif($reserva->estado == 'confirmada') bg-green-100 text-green-800
                                                @else bg-red-100 text-red-800 @endif">
                                                {{ ucfirst($reserva->estado) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500">No hay reservas recientes.</p>
                    @endif
                </div>
            </div>

            <!-- Enlaces rápidos -->
            <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('admin.espacios.index') }}" class="bg-indigo-100 hover:bg-indigo-200 text-indigo-800 font-semibold py-2 px-4 rounded-lg text-center transition">
                    Gestionar espacios
                </a>
                <a href="{{ route('admin.tipos-espacio.index') }}" class="bg-emerald-100 hover:bg-emerald-200 text-emerald-800 font-semibold py-2 px-4 rounded-lg text-center transition">
                    Tipos de espacio
                </a>
                <a href="{{ route('admin.reservas.hoy') }}" class="bg-amber-100 hover:bg-amber-200 text-amber-800 font-semibold py-2 px-4 rounded-lg text-center transition">
                    Reservas del día
                </a>
                <a href="{{ route('admin.ocupacion') }}" class="bg-rose-100 hover:bg-rose-200 text-rose-800 font-semibold py-2 px-4 rounded-lg text-center transition">
                    Ocupación general
                </a>
            </div>
        </div>
    </div>
</x-app-layout>