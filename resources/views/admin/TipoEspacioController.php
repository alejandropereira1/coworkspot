<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TipoEspacio;

class TipoEspacioController extends Controller
{
    /**
     * Lista todos los tipos de espacio.
     */
    public function index()
    {
        $tipos = TipoEspacio::withCount('espacios')->get();
        return view('admin.tipos-espacio.index', compact('tipos'));
    }

    /**
     * Muestra el formulario para crear un nuevo tipo.
     */
    public function create()
    {
        return view('admin.tipos-espacio.create');
    }

    /**
     * Almacena un nuevo tipo de espacio.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:tipos_espacio',
            'descripcion' => 'nullable|string',
        ]);

        TipoEspacio::create($request->all());

        return redirect()->route('admin.tipos-espacio.index')
            ->with('success', 'Tipo de espacio creado correctamente.');
    }

    /**
     * Muestra un tipo de espacio específico.
     */
    public function show(TipoEspacio $tipoEspacio)
    {
        return view('admin.tipos-espacio.show', compact('tipoEspacio'));
    }

    /**
     * Muestra el formulario para editar un tipo.
     */
    public function edit(TipoEspacio $tipoEspacio)
    {
        return view('admin.tipos-espacio.edit', compact('tipoEspacio'));
    }

    /**
     * Actualiza un tipo de espacio.
     */
    public function update(Request $request, TipoEspacio $tipoEspacio)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:tipos_espacio,nombre,' . $tipoEspacio->id,
            'descripcion' => 'nullable|string',
        ]);

        $tipoEspacio->update($request->all());

        return redirect()->route('admin.tipos-espacio.index')
            ->with('success', 'Tipo de espacio actualizado correctamente.');
    }

    /**
     * Elimina un tipo de espacio.
     */
    public function destroy(TipoEspacio $tipoEspacio)
    {
        $tipoEspacio->delete();

        return redirect()->route('admin.tipos-espacio.index')
            ->with('success', 'Tipo de espacio eliminado correctamente.');
    }
}