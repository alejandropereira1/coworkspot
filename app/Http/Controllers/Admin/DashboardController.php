<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Models\Espacio;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Muestra el panel de administración.
     */
    public function index()
    {
        // Estadísticas básicas para el dashboard
        $totalEspacios = Espacio::count();
        $totalReservasHoy = Reserva::where('fecha', Carbon::today())->count();
        $totalUsuarios = User::count();
        $reservasPendientes = Reserva::where('estado', 'pendiente')->count();

        // Reservas recientes para mostrar en el dashboard
        $reservasRecientes = Reserva::with(['espacio', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalEspacios',
            'totalReservasHoy',
            'totalUsuarios',
            'reservasPendientes',
            'reservasRecientes'
        ));
    }
}