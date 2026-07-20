<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Models\Espacio;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log; // Para depuración (opcional)

class ReservaController extends Controller
{
    /**
     * Mostrar el formulario de reserva para un espacio.
     */
    public function create(Espacio $espacio)
    {
        return view('reservas.create', compact('espacio'));
    }

    /**
     * Almacenar una nueva reserva.
     */
    public function store(Request $request)
    {
        $request->validate([
            'espacio_id' => 'required|exists:espacios,id',
            'fecha' => 'required|date|after_or_equal:today',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
        ]);

        $espacio = Espacio::findOrFail($request->espacio_id);

        // Verificar disponibilidad (sin solapamiento)
        $conflict = Reserva::where('espacio_id', $espacio->id)
            ->where('fecha', $request->fecha)
            ->where('estado', '!=', 'cancelada')
            ->where(function ($query) use ($request) {
                $query->whereBetween('hora_inicio', [$request->hora_inicio, $request->hora_fin])
                      ->orWhereBetween('hora_fin', [$request->hora_inicio, $request->hora_fin])
                      ->orWhere(function ($q) use ($request) {
                          $q->where('hora_inicio', '<=', $request->hora_inicio)
                            ->where('hora_fin', '>=', $request->hora_fin);
                      });
            })
            ->exists();

        if ($conflict) {
            return back()->withErrors(['error' => 'El espacio ya está reservado en ese horario.']);
        }

        // Calcular precio total (SIEMPRE POSITIVO)
        $start = Carbon::parse($request->hora_inicio);
        $end = Carbon::parse($request->hora_fin);
        $horas = abs($end->diffInHours($start)); // ← Asegurar positivo
        $precio_total = $horas * abs($espacio->precio_por_hora); // ← Precio por hora positivo

        // Crear la reserva
        $reserva = Reserva::create([
            'espacio_id' => $espacio->id,
            'usuario_id' => Auth::id(),
            'fecha' => $request->fecha,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
            'precio_total' => $precio_total,
            'estado' => 'pendiente',
        ]);

        return redirect()->route('reservas.mis')
            ->with('success', 'Reserva creada correctamente. Esperando confirmación.');
    }

    /**
     * Mostrar las reservas del usuario autenticado.
     */
    public function misReservas()
    {
        $reservas = Reserva::where('usuario_id', Auth::id())
            ->with('espacio')
            ->orderBy('fecha', 'desc')
            ->get();

        return view('reservas.mis', compact('reservas'));
    }

    /**
     * Cancelar una reserva (solo el dueño o admin).
     */
    public function cancelar(Reserva $reserva)
    {
        $user = Auth::user();

        // Verificar que el usuario sea el dueño o admin
        if ($reserva->usuario_id !== $user->id && $user->role !== 'admin') {
            return back()->withErrors(['error' => 'No tienes permiso para cancelar esta reserva.']);
        }

        // Si es el dueño (no admin), verificar que falten más de 2 horas
        if ($reserva->usuario_id === $user->id && $user->role !== 'admin') {
            $inicio = Carbon::parse($reserva->fecha . ' ' . $reserva->hora_inicio);
            $ahora = Carbon::now();

            if ($ahora->diffInHours($inicio, false) <= 2) {
                return back()->withErrors(['error' => 'Solo puedes cancelar con más de 2 horas de anticipación.']);
            }
        }

        $reserva->estado = 'cancelada';
        $reserva->save();

        return back()->with('success', 'Reserva cancelada correctamente.');
    }

    /**
     * Ver disponibilidad de un espacio (AJAX).
     */
    public function disponibilidad(Request $request, Espacio $espacio)
    {
        $request->validate([
            'fecha' => 'required|date',
        ]);

        $reservas = Reserva::where('espacio_id', $espacio->id)
            ->where('fecha', $request->fecha)
            ->where('estado', '!=', 'cancelada')
            ->get(['hora_inicio', 'hora_fin']);

        return response()->json($reservas);
    }
}