<?php

namespace App\Http\Controllers;

use App\Models\TipoEspacio;
use App\Models\Espacio;

class EspacioController extends Controller
{
    // Listado de espacios agrupados por tipo
    public function index()
    {
        $tipos = TipoEspacio::with(['espacios' => function ($q) {
            $q->where('activo', true)->with('comodidades');
        }])->get();

        return view('espacios.index', compact('tipos'));
    }

    // Detalle de un espacio
    public function show(Espacio $espacio)
    {
        $espacio->load('comodidades', 'tipo');
        return view('espacios.show', compact('espacio'));
    }
}