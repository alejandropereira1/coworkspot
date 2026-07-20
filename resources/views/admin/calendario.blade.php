<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Calendario semanal - {{ $espacio->nombre }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Hora</th>
                                @foreach($dias as $dia)
                                    <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">
                                        {{ $dia->format('D') }}<br>
                                        {{ $dia->format('d/m') }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($horas as $hora)
                            <tr>
                                <td class="px-4 py-2 text-sm font-medium">{{ $hora }}</td>
                                @foreach($dias as $dia)
                                    @php
                                        $estado = $ocupacion[$dia->format('Y-m-d')][$hora] ?? 'libre';
                                        $color = [
                                            'libre' => 'bg-green-100 text-green-800',
                                            'pendiente' => 'bg-yellow-100 text-yellow-800',
                                            'confirmado' => 'bg-blue-100 text-blue-800',
                                        ][$estado] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <td class="px-4 py-2 text-center text-xs {{ $color }} rounded">
                                        {{ ucfirst($estado) }}
                                    </td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>