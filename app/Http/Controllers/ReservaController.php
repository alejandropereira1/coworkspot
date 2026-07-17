<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Espacio;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReservaController extends Controller
{
    // Mostrar disponibilidad para un espacio en una fecha
    public function disponibilidad(Request $request, Espacio $espacio)
    {
        $request->validate(['fecha' => 'required|date|after_or_equal:today']);

        // Consultar reservas de ese espacio en esa fecha (pendientes o confirmadas)
        $reservas = $espacio->reservas()
            ->where('fecha', $request->fecha)
            ->whereIn('estado', ['pendiente', 'confirmada'])
            ->get(['hora_inicio', 'hora_fin']);

        return view('espacios.disponibilidad', compact('espacio', 'reservas', 'request'));
    }

    // Crear una reserva
    public function store(Request $request)
    {
        $request->validate([
            'espacio_id' => 'required|exists:espacios,id',
            'fecha' => 'required|date|after_or_equal:today',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
        ]);

        $espacio = Espacio::findOrFail($request->espacio_id);
        $inicio = Carbon::createFromFormat('H:i', $request->hora_inicio);
        $fin = Carbon::createFromFormat('H:i', $request->hora_fin);
        $horas = $inicio->floatDiffInHours($fin);

        // Verificar solapamiento
        $solapado = $espacio->reservas()
            ->where('fecha', $request->fecha)
            ->whereIn('estado', ['pendiente', 'confirmada'])
            ->where(function ($q) use ($inicio, $fin) {
                $q->where(function ($sub) use ($inicio, $fin) {
                    $sub->where('hora_inicio', '<', $fin->format('H:i'))
                        ->where('hora_fin', '>', $inicio->format('H:i'));
                });
            })
            ->exists();

        if ($solapado) {
            return back()->withErrors(['msg' => 'El espacio ya está reservado en ese horario.']);
        }

        $precio_total = $horas * $espacio->precio_por_hora;

        $reserva = Reserva::create([
            'espacio_id' => $espacio->id,
            'usuario_id' => auth()->id(),
            'fecha' => $request->fecha,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
            'precio_total' => $precio_total,
            'estado' => 'pendiente',
        ]);

        return redirect()->route('reservas.mis')->with('exito', 'Reserva creada correctamente.');
    }

    // Mis reservas
    public function misReservas()
    {
        $reservas = auth()->user()->reservas()->with('espacio')->orderBy('fecha', 'desc')->get();
        return view('reservas.mis', compact('reservas'));
    }

    // Cancelar reserva (dueño, con más de 2h de anticipación)
    public function cancelar(Reserva $reserva)
    {
        if ($reserva->usuario_id !== auth()->id()) {
            abort(403);
        }

        $ahora = now();
        $fechaHoraReserva = Carbon::parse($reserva->fecha->format('Y-m-d') . ' ' . $reserva->hora_inicio);
        $horasFaltantes = $ahora->diffInHours($fechaHoraReserva, false);

        if ($horasFaltantes < 2 && $fechaHoraReserva->isFuture()) {
            return back()->withErrors(['msg' => 'Solo puedes cancelar con al menos 2 horas de anticipación.']);
        }

        $reserva->update(['estado' => 'cancelada']);
        return back()->with('exito', 'Reserva cancelada.');
    }
}