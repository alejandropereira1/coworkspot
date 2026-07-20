<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Models\Espacio;
use Carbon\Carbon;

class ReservaController extends Controller
{
    /**
     * Muestra todas las reservas del día actual.
     */
    public function hoy()
    {
        $hoy = Carbon::today();
        $reservas = Reserva::where('fecha', $hoy)
            ->with(['espacio', 'user'])
            ->orderBy('hora_inicio')
            ->get();

        return view('admin.reservas.hoy', compact('reservas', 'hoy'));
    }

    /**
     * Confirma una reserva.
     */
    public function confirmar(Reserva $reserva)
    {
        $reserva->estado = 'confirmada';
        $reserva->save();

        return back()->with('success', 'Reserva confirmada correctamente.');
    }

    /**
     * Cancela una reserva (admin).
     */
    public function cancelar(Reserva $reserva)
    {
        $reserva->estado = 'cancelada';
        $reserva->save();

        return back()->with('success', 'Reserva cancelada correctamente.');
    }

    /**
     * Muestra la ocupación general por espacio.
     */
    public function ocupacion()
    {
        $espacios = Espacio::with(['reservas' => function ($query) {
            $query->where('fecha', Carbon::today())
                ->where('estado', '!=', 'cancelada');
        }])->get();

        $totalReservasHoy = Reserva::where('fecha', Carbon::today())
            ->where('estado', '!=', 'cancelada')
            ->count();

        return view('admin.ocupacion', compact('espacios', 'totalReservasHoy'));
    }

    /**
     * Muestra el calendario semanal de un espacio.
     */
    public function calendario(Espacio $espacio)
    {
        // Obtenemos el lunes de esta semana
        $hoy = Carbon::now();
        $lunes = $hoy->copy()->startOfWeek();

        // Días de la semana
        $dias = [];
        for ($i = 0; $i < 7; $i++) {
            $dias[] = $lunes->copy()->addDays($i);
        }

        // Horas (de 8 AM a 8 PM)
        $horas = [];
        for ($h = 8; $h <= 20; $h++) {
            $horas[] = sprintf('%02d:00', $h);
        }

        // Obtener reservas de la semana para este espacio
        $reservas = Reserva::where('espacio_id', $espacio->id)
            ->whereBetween('fecha', [$lunes, $lunes->copy()->addDays(6)])
            ->where('estado', '!=', 'cancelada')
            ->get();

        // Construir matriz de ocupación
        $ocupacion = [];
        foreach ($dias as $dia) {
            foreach ($horas as $hora) {
                $ocupacion[$dia->format('Y-m-d')][$hora] = 'libre';
            }
        }

        foreach ($reservas as $reserva) {
            $fecha = $reserva->fecha;
            $inicio = $reserva->hora_inicio;
            $fin = $reserva->hora_fin;

            foreach ($horas as $hora) {
                if ($hora >= $inicio && $hora < $fin) {
                    $ocupacion[$fecha][$hora] = $reserva->estado === 'confirmada' ? 'confirmado' : 'pendiente';
                }
            }
        }

        return view('admin.calendario', compact('espacio', 'dias', 'horas', 'ocupacion'));
    }
}