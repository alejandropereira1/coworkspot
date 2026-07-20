<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comodidad;
use App\Models\Espacio;

class ComodidadController extends Controller
{
    /**
     * Lista las comodidades de un espacio.
     */
    public function index(Espacio $espacio)
    {
        $comodidades = $espacio->comodidades;
        return view('admin.comodidades.index', compact('espacio', 'comodidades'));
    }

    /**
     * Muestra el formulario para crear una nueva comodidad.
     */
    public function create(Espacio $espacio)
    {
        return view('admin.comodidades.create', compact('espacio'));
    }

    /**
     * Almacena una nueva comodidad.
     */
    public function store(Request $request, Espacio $espacio)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        Comodidad::create([
            'espacio_id' => $espacio->id,
            'nombre' => $request->nombre,
        ]);

        return redirect()->route('admin.espacios.comodidades.index', $espacio)
            ->with('success', 'Comodidad creada correctamente.');
    }

    /**
     * Muestra una comodidad específica.
     */
    public function show(Espacio $espacio, Comodidad $comodidad)
    {
        return view('admin.comodidades.show', compact('espacio', 'comodidad'));
    }

    /**
     * Muestra el formulario para editar una comodidad.
     */
    public function edit(Espacio $espacio, Comodidad $comodidad)
    {
        return view('admin.comodidades.edit', compact('espacio', 'comodidad'));
    }

    /**
     * Actualiza una comodidad.
     */
    public function update(Request $request, Espacio $espacio, Comodidad $comodidad)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $comodidad->update(['nombre' => $request->nombre]);

        return redirect()->route('admin.espacios.comodidades.index', $espacio)
            ->with('success', 'Comodidad actualizada correctamente.');
    }

    /**
     * Elimina una comodidad.
     */
    public function destroy(Espacio $espacio, Comodidad $comodidad)
    {
        $comodidad->delete();

        return redirect()->route('admin.espacios.comodidades.index', $espacio)
            ->with('success', 'Comodidad eliminada correctamente.');
    }
}