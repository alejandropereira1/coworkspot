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
    public function index()
    {
        $espacios = Espacio::with(['tipo', 'comodidades'])->get();
        return view('admin.espacios.index', compact('espacios'));
    }

    public function create()
    {
        $tipos = TipoEspacio::all();
        $comodidades = Comodidad::all();
        return view('admin.espacios.create', compact('tipos', 'comodidades'));
    }

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

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('spaces', 'public');
            $data['image'] = $path;
        }

        $espacio = Espacio::create($data);

        // 🔥 CORREGIDO: Crear comodidades asociadas al espacio
        if ($request->has('comodidades')) {
            foreach ($request->comodidades as $comodidadId) {
                Comodidad::create([
                    'espacio_id' => $espacio->id,
                    'nombre' => $comodidadId, // ⚠️ Esto asume que el array contiene nombres, no IDs
                ]);
            }
        }

        return redirect()->route('admin.espacios.index')
            ->with('success', 'Espacio creado correctamente.');
    }

    public function show(Espacio $espacio)
    {
        return view('admin.espacios.show', compact('espacio'));
    }

    public function edit(Espacio $espacio)
    {
        $tipos = TipoEspacio::all();
        $comodidades = Comodidad::all();
        $espacioComodidades = $espacio->comodidades->pluck('id')->toArray();
        return view('admin.espacios.edit', compact('espacio', 'tipos', 'comodidades', 'espacioComodidades'));
    }

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

        if ($request->hasFile('image')) {
            if ($espacio->image && Storage::disk('public')->exists($espacio->image)) {
                Storage::disk('public')->delete($espacio->image);
            }
            $path = $request->file('image')->store('spaces', 'public');
            $data['image'] = $path;
        }

        $espacio->update($data);

        // 🔥 CORREGIDO: Eliminar comodidades existentes y crear las nuevas
        $espacio->comodidades()->delete();

        if ($request->has('comodidades')) {
            foreach ($request->comodidades as $comodidadId) {
                Comodidad::create([
                    'espacio_id' => $espacio->id,
                    'nombre' => $comodidadId, // ⚠️ Esto asume que el array contiene nombres, no IDs
                ]);
            }
        }

        return redirect()->route('admin.espacios.index')
            ->with('success', 'Espacio actualizado correctamente.');
    }

    public function destroy(Espacio $espacio)
    {
        if ($espacio->image && Storage::disk('public')->exists($espacio->image)) {
            Storage::disk('public')->delete($espacio->image);
        }

        $espacio->delete();

        return redirect()->route('admin.espacios.index')
            ->with('success', 'Espacio eliminado correctamente.');
    }
}