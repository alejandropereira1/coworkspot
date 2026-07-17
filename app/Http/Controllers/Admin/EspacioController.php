<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Espacio;
use App\Models\TipoEspacio;
use App\Models\Comodidad;
use Illuminate\Support\Facades\Storage;

class EspacioController extends Controller
{
    /**
     * Muestra el listado de espacios (admin).
     */
    public function index()
    {
        $espacios = Espacio::with(['tipo', 'comodidades'])->get();
        return view('admin.espacios.index', compact('espacios'));
    }

    /**
     * Muestra el formulario para crear un nuevo espacio.
     */
    public function create()
    {
        $tipos = TipoEspacio::all();
        $comodidades = Comodidad::all();
        return view('admin.espacios.create', compact('tipos', 'comodidades'));
    }

    /**
     * Almacena un nuevo espacio en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo_espacio_id' => 'required|exists:tipos_espacio,id',
            'capacidad' => 'required|integer|min:1',
            'precio_por_hora' => 'required|numeric|min:0',
            'piso' => 'nullable|integer',
            'activo' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'comodidades' => 'array',
            'comodidades.*' => 'exists:comodidades,id',
        ]);

        $data = $request->all();

        // Subir imagen si existe
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('spaces', 'public');
            $data['image'] = $path;
        }

        $espacio = Espacio::create($data);

        // Asignar comodidades
        if ($request->has('comodidades')) {
            $espacio->comodidades()->sync($request->comodidades);
        }

        return redirect()->route('admin.espacios.index')
            ->with('success', 'Espacio creado correctamente.');
    }

    /**
     * Muestra un espacio específico (detalle).
     */
    public function show(Espacio $espacio)
    {
        return view('admin.espacios.show', compact('espacio'));
    }

    /**
     * Muestra el formulario para editar un espacio.
     */
    public function edit(Espacio $espacio)
    {
        $tipos = TipoEspacio::all();
        $comodidades = Comodidad::all();
        $espacioComodidades = $espacio->comodidades->pluck('id')->toArray();
        return view('admin.espacios.edit', compact('espacio', 'tipos', 'comodidades', 'espacioComodidades'));
    }

    /**
     * Actualiza un espacio en la base de datos.
     */
    public function update(Request $request, Espacio $espacio)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo_espacio_id' => 'required|exists:tipos_espacio,id',
            'capacidad' => 'required|integer|min:1',
            'precio_por_hora' => 'required|numeric|min:0',
            'piso' => 'nullable|integer',
            'activo' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'comodidades' => 'array',
            'comodidades.*' => 'exists:comodidades,id',
        ]);

        $data = $request->all();

        // Subir nueva imagen si se proporciona
        if ($request->hasFile('image')) {
            // Eliminar imagen anterior si existe
            if ($espacio->image && Storage::disk('public')->exists($espacio->image)) {
                Storage::disk('public')->delete($espacio->image);
            }
            $path = $request->file('image')->store('spaces', 'public');
            $data['image'] = $path;
        }

        $espacio->update($data);

        // Actualizar comodidades
        if ($request->has('comodidades')) {
            $espacio->comodidades()->sync($request->comodidades);
        } else {
            $espacio->comodidades()->sync([]);
        }

        return redirect()->route('admin.espacios.index')
            ->with('success', 'Espacio actualizado correctamente.');
    }

    /**
     * Elimina un espacio de la base de datos.
     */
    public function destroy(Espacio $espacio)
    {
        // Eliminar imagen asociada si existe
        if ($espacio->image && Storage::disk('public')->exists($espacio->image)) {
            Storage::disk('public')->delete($espacio->image);
        }

        $espacio->delete();

        return redirect()->route('admin.espacios.index')
            ->with('success', 'Espacio eliminado correctamente.');
    }
}