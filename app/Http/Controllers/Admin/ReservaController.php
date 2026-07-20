<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Models\Espacio;
use Carbon\Carbon;

class ReservaController extends Controller
{
    public function hoy()
    {
        $reservas = Reserva::with(['espacio', 'user'])
            ->where('fecha', Carbon::today())
            ->orderBy('hora_inicio')
            ->get();

        return view('admin.reservas.hoy', compact('reservas'));
    }

    public function confirmar(Reserva $reserva)
    {
        $reserva->estado = 'confirmada';
        $reserva->save();
        return back()->with('success', 'Reserva confirmada correctamente.');
    }

    public function cancelar(Reserva $reserva)
    {
        $reserva->estado = 'cancelada';
        $reserva->save();
        return back()->with('success', 'Reserva cancelada correctamente.');
    }

    public function ocupacion()
    {
        $espacios = Espacio::withCount(['reservas' => function ($query) {
            $query->where('fecha', Carbon::today())
                ->where('estado', '!=', 'cancelada');
        }])->get();

        return view('admin.ocupacion', compact('espacios'));
    }

    public function calendario(Espacio $espacio)
    {
        // Generar días de la semana
        $hoy = Carbon::today();
        $semana = collect(range(0, 6))->map(function ($i) use ($hoy) {
            return $hoy->copy()->addDays($i);
        });

        // Generar horas (8:00 a 20:00)
        $horas = collect(range(8, 20))->map(function ($h) {
            return sprintf('%02d:00', $h);
        });

        $reservas = Reserva::where('espacio_id', $espacio->id)
            ->whereBetween('fecha', [$semana->first(), $semana->last()])
            ->where('estado', '!=', 'cancelada')
            ->get()
            ->groupBy(function ($reserva) {
                return Carbon::parse($reserva->fecha)->format('Y-m-d');
            });

        return view('admin.calendario', compact('espacio', 'semana', 'horas', 'reservas'));
    }
}