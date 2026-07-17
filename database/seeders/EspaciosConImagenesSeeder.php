<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Espacio;
use App\Models\TipoEspacio;

class EspaciosConImagenesSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Asegurar que los tipos de espacio existan
        $tipos = [
            'Escritorio compartido' => TipoEspacio::firstOrCreate(
                ['nombre' => 'Escritorio compartido'],
                ['descripcion' => 'Puesto de trabajo en área abierta, ideal para freelancers.']
            ),
            'Sala de reuniones' => TipoEspacio::firstOrCreate(
                ['nombre' => 'Sala de reuniones'],
                ['descripcion' => 'Salas privadas para equipos, con equipamiento para presentación.']
            ),
            'Oficina privada' => TipoEspacio::firstOrCreate(
                ['nombre' => 'Oficina privada'],
                ['descripcion' => 'Oficina cerrada con privacidad total para tu equipo.']
            ),
        ];

        // 2. Definir los espacios (con imágenes de tamaño fijo 600x400)
        $espaciosData = [
            [
                'nombre' => 'Escritorio A1',
                'tipo' => 'Escritorio compartido',
                'capacidad' => 1,
                'precio_por_hora' => 5000,
                'piso' => 1,
                'activo' => true,
                'image' => 'https://images.unsplash.com/photo-1535957998253-26ae1ef29506?w=600&h=400&fit=crop&crop=center',
            ],
            [
                'nombre' => 'Escritorio B3',
                'tipo' => 'Escritorio compartido',
                'capacidad' => 1,
                'precio_por_hora' => 5000,
                'piso' => 1,
                'activo' => true,
                'image' => 'https://images.unsplash.com/photo-1549399905-5d1bad747576?w=600&h=400&fit=crop&crop=center',
            ],
            [
                'nombre' => 'Sala Las Palmas',
                'tipo' => 'Sala de reuniones',
                'capacidad' => 6,
                'precio_por_hora' => 15000,
                'piso' => 2,
                'activo' => true,
                'image' => 'https://images.unsplash.com/photo-1603430416744-a47cee46b0ae?w=600&h=400&fit=crop&crop=center',
            ],
            [
                'nombre' => 'Sala El Nogal',
                'tipo' => 'Sala de reuniones',
                'capacidad' => 10,
                'precio_por_hora' => 25000,
                'piso' => 2,
                'activo' => true,
                'image' => 'https://images.unsplash.com/photo-1497366754035-f200968a6e72?w=600&h=400&fit=crop&crop=center',
            ],
            [
                'nombre' => 'Oficina 201',
                'tipo' => 'Oficina privada',
                'capacidad' => 4,
                'precio_por_hora' => 20000,
                'piso' => 4,
                'activo' => true,
                'image' => 'https://images.unsplash.com/photo-1542089363-bba089ffaa25?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            ],
            [
                'nombre' => 'Oficina 301 Premium',
                'tipo' => 'Oficina privada',
                'capacidad' => 6,
                'precio_por_hora' => 28000,
                'piso' => 4,
                'activo' => true,
                'image' => 'https://images.unsplash.com/photo-1706074793638-da28b90ea8ae?q=80&w=856&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            ],
        ];

        // 3. Crear o actualizar espacios
        foreach ($espaciosData as $data) {
            $tipoEspacio = $tipos[$data['tipo']];

            // Buscar si ya existe un espacio con ese nombre y tipo
            $espacio = Espacio::where('nombre', $data['nombre'])
                              ->where('tipo_espacio_id', $tipoEspacio->id)
                              ->first();

            if ($espacio) {
                // Si existe, actualizar solo la imagen (y otros campos si quieres)
                $espacio->update([
                    'image' => $data['image'],
                    // si quieres actualizar otros campos, descomenta:
                    // 'capacidad' => $data['capacidad'],
                    // 'precio_por_hora' => $data['precio_por_hora'],
                    // 'piso' => $data['piso'],
                    // 'activo' => $data['activo'],
                ]);
                $this->command->info("✅ Imagen actualizada para '{$data['nombre']}'");
            } else {
                // Si no existe, crearlo
                Espacio::create([
                    'tipo_espacio_id' => $tipoEspacio->id,
                    'nombre' => $data['nombre'],
                    'capacidad' => $data['capacidad'],
                    'precio_por_hora' => $data['precio_por_hora'],
                    'piso' => $data['piso'],
                    'activo' => $data['activo'],
                    'image' => $data['image'],
                ]);
                $this->command->info("🆕 Espacio creado: '{$data['nombre']}'");
            }
        }

        $this->command->info('🎉 ¡Proceso completado! Todos los espacios tienen imagen.');
    }
}