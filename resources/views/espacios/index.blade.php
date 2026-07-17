<x-app-layout>
    <x-slot name="header">
        {{-- Cabecera con imagen de fondo y bordes redondeados --}}
        <div class="relative overflow-hidden rounded-xl py-12 px-6 text-center"
             style="background-image: url('https://oficinacreativaxd.com/wp-content/uploads/2026/01/03122025-IMG_2180-1024x1536.jpg');
                    background-size: cover;
                    background-position: center;
                    background-blend-mode: overlay;">
            {{-- Capa oscura para legibilidad --}}
            <div class="absolute inset-0 bg-indigo-900/70 rounded-xl"></div>

            <div class="relative z-10">
                <h1 class="text-4xl md:text-5xl font-extrabold text-white tracking-tight drop-shadow-lg">
                    Espacios de Coworking Disponibles
                </h1>
                <p class="mt-3 text-indigo-100 max-w-2xl mx-auto text-base md:text-lg">
                    Reserve el entorno ideal para el desarrollo de sus actividades corporativas. Espacios optimizados para la productividad, la concentración y el trabajo colaborativo.
                </p>
            </div>
        </div>
    </x-slot>

    {{-- Filtros (con formulario GET) --}}
    <form action="{{ route('inicio') }}" method="GET" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 relative z-20">
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200/80 p-4 md:p-6 flex flex-wrap items-center gap-4">
            <div class="flex-1 min-w-[160px]">
                <label for="tipo" class="block text-xs font-medium text-slate-500 uppercase tracking-wider mb-1">Tipo</label>
                <select name="tipo" id="tipo" class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    <option value="">Todos los tipos</option>
                    @foreach ($tipos as $tipo)
                        <option value="{{ $tipo->id }}" {{ request('tipo') == $tipo->id ? 'selected' : '' }}>
                            {{ $tipo->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1 min-w-[160px]">
                <label for="fecha" class="block text-xs font-medium text-slate-500 uppercase tracking-wider mb-1">Fecha</label>
                <input type="date" name="fecha" id="fecha" value="{{ request('fecha') }}" class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl transition shadow-md hover:shadow-lg text-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                    Buscar
                </button>
                <a href="{{ route('inicio') }}" class="px-4 py-2.5 text-slate-500 hover:text-slate-700 text-sm font-medium">Limpiar</a>
            </div>
        </div>
    </form>

    {{-- Listado de espacios --}}
    <div class="py-12 bg-slate-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @foreach ($tipos as $tipo)
                <div class="mb-16 last:mb-0">
                    {{-- Encabezado del tipo --}}
                    <div class="flex flex-col md:flex-row md:items-baseline border-b-2 border-indigo-100 pb-4 mb-8 gap-2">
                        <h3 class="text-2xl font-bold text-slate-800 tracking-tight flex items-center gap-3">
                            @if($tipo->nombre == 'Escritorio compartido')
                                <span class="p-2 bg-indigo-100 rounded-xl text-indigo-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25"/></svg>
                                </span>
                            @elseif($tipo->nombre == 'Sala de reuniones')
                                <span class="p-2 bg-emerald-100 rounded-xl text-emerald-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z"/></svg>
                                </span>
                            @else
                                <span class="p-2 bg-amber-100 rounded-xl text-amber-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z"/></svg>
                                </span>
                            @endif
                            {{ $tipo->nombre }}
                            <span class="ml-2 text-sm font-normal text-slate-400 bg-slate-100 px-3 py-0.5 rounded-full">{{ $tipo->espacios->count() }} espacios</span>
                        </h3>
                        <p class="md:ml-4 text-sm text-slate-500 italic">{{ $tipo->descripcion }}</p>
                    </div>

                    {{-- Grid de tarjetas --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach ($tipo->espacios as $espacio)
                            <div class="group bg-white rounded-2xl shadow-md hover:shadow-2xl border border-slate-200/80 hover:border-indigo-300 transition-all duration-300 flex flex-col overflow-hidden transform hover:-translate-y-1">
                                
                                {{-- Imagen --}}
                                <div class="h-48 overflow-hidden relative bg-slate-100">
                                    @if($espacio->image)
                                        <img src="{{ $espacio->image }}" 
                                             alt="{{ $espacio->nombre }}" 
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-indigo-100 to-blue-100 flex items-center justify-center text-slate-400">
                                            <svg class="w-16 h-16 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9.75M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 14.25M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9.75M20.25 20.25h-4.5m4.5 0v-4.5m0 4.5L15 14.25"/>
                                            </svg>
                                        </div>
                                    @endif

                                    {{-- Badges --}}
                                    <span class="absolute top-3 left-3 bg-white/80 backdrop-blur-sm text-slate-700 text-xs font-semibold px-3 py-1 rounded-full shadow-sm flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                        </svg>
                                        Piso {{ $espacio->piso ?? 'N/A' }}
                                    </span>
                                    @if($espacio->activo)
                                        <span class="absolute top-3 right-3 bg-emerald-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-md flex items-center gap-1">
                                            <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span> Disponible
                                        </span>
                                    @else
                                        <span class="absolute top-3 right-3 bg-rose-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-md">Ocupado</span>
                                    @endif
                                </div>

                                {{-- Contenido --}}
                                <div class="p-5 flex-1 flex flex-col">
                                    <h4 class="text-xl font-bold text-slate-900 tracking-tight">{{ $espacio->nombre }}</h4>
                                    
                                    <div class="mt-2 flex items-center gap-3 text-sm text-slate-500">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                            </svg>
                                            {{ $espacio->capacidad }} corporativo(s)
                                        </span>
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            {{ $espacio->precio_por_hora }} COP/h
                                        </span>
                                    </div>

                                    {{-- Precio destacado --}}
                                    <div class="mt-3 bg-gradient-to-r from-indigo-50 to-blue-50 rounded-xl p-3 border border-indigo-100 flex items-center justify-between">
                                        <span class="text-xs font-semibold text-indigo-700 uppercase tracking-wide">Tarifa por hora</span>
                                        <span class="text-2xl font-extrabold text-indigo-700">${{ number_format($espacio->precio_por_hora, 0, ',', '.') }}</span>
                                    </div>

                                    {{-- Servicios incluidos --}}
                                    <div class="mt-4">
                                        <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block mb-2">Servicios incluidos</span>
                                        <div class="flex flex-wrap gap-1.5">
                                            @forelse ($espacio->comodidades as $comodidad)
                                                <span class="inline-flex items-center bg-slate-100 text-slate-700 text-xs font-medium px-3 py-1.5 rounded-full border border-slate-200/60 shadow-sm">
                                                    <svg class="w-3 h-3 mr-1.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                    {{ $comodidad->nombre }}
                                                </span>
                                            @empty
                                                <span class="text-xs text-slate-400 italic">Este espacio no tiene servicios adicionales registrados.</span>
                                            @endforelse
                                        </div>
                                    </div>

                                    {{-- Ocupación del día --}}
                                    <div class="mt-4 pt-3 border-t border-slate-200/60 flex items-center text-xs text-slate-400">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span>4 reservas hoy</span>
                                        <span class="mx-2">•</span>
                                        <span class="text-emerald-600 font-medium">2 disponibles</span>
                                    </div>
                                </div>

                                {{-- Botón --}}
                                <div class="p-4 bg-slate-50 border-t border-slate-100">
                                    <a href="{{ route('espacios.show', $espacio) }}"
                                       class="group-hover:shadow-lg block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-xl transition-all duration-200 text-sm tracking-wide shadow-md flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        Solicitar Reserva
                                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>