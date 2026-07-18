<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // <-- Importante para recibir los parámetros
use App\Models\TipoEspacio;
use App\Models\Espacio;

class EspacioController extends Controller
{
    /**
     * Listado de espacios agrupados por tipo (con filtros)
     */
    public function index(Request $request)
    {
        // Obtener parámetros de filtro
        $tipoId = $request->input('tipo');
        $fecha = $request->input('fecha');

        // Consulta base: tipos de espacio con sus espacios activos y comodidades
        $query = TipoEspacio::with(['espacios' => function ($q) {
            $q->where('activo', true)->with('comodidades');
        }]);

        // Aplicar filtro por tipo si se seleccionó
        if ($tipoId) {
            $query->where('id', $tipoId);
        }

        // Obtener los tipos filtrados
        $tipos = $query->get();

        // Pasar la fecha a la vista (aunque no se use aún, queda para futura lógica)
        return view('espacios.index', compact('tipos', 'fecha'));
    }

    /**
     * Detalle de un espacio
     */
    public function show(Espacio $espacio)
    {
        $espacio->load('comodidades', 'tipo');
        return view('espacios.show', compact('espacio'));
    }
}