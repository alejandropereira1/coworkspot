<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\TipoEspacio;
use App\Models\Espacio;
use Illuminate\Foundation\Testing\RefreshDatabase;


class EspacioTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_espacios_list()
    {
        $tipo = TipoEspacio::factory()->create();
        Espacio::factory()->count(3)->create(['tipo_espacio_id' => $tipo->id]);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertViewHas('tipos');
    }

    public function test_user_can_view_espacio_detail()
    {
        $tipo = TipoEspacio::factory()->create();
        $espacio = Espacio::factory()->create(['tipo_espacio_id' => $tipo->id]);

        $response = $this->get(route('espacios.show', $espacio));
        $response->assertStatus(200);
        $response->assertViewHas('espacio', $espacio);
    }

    public function test_admin_can_create_espacio()
    {
        $admin = User::factory()->admin()->create();
        $tipo = TipoEspacio::factory()->create();

        $data = [
            'nombre' => 'Oficina Premium',
            'tipo_espacio_id' => $tipo->id,
            'capacidad' => 4,
            'precio_por_hora' => 30000,
            'piso' => 2,
            'activo' => true,
        ];

        $response = $this->actingAs($admin)->post(route('admin.espacios.store'), $data);
        $response->assertRedirect(route('admin.espacios.index'));
        $this->assertDatabaseHas('espacios', ['nombre' => 'Oficina Premium']);
    }

    public function test_admin_can_update_espacio()
    {
        $admin = User::factory()->admin()->create();
        $tipo = TipoEspacio::factory()->create();
        $espacio = Espacio::factory()->create(['tipo_espacio_id' => $tipo->id]);

        $data = [
            'nombre' => 'Nuevo Nombre',
            'tipo_espacio_id' => $tipo->id,
            'capacidad' => 6,
            'precio_por_hora' => 40000,
            'piso' => 3,
            'activo' => false,
        ];

        $response = $this->actingAs($admin)->put(route('admin.espacios.update', $espacio), $data);
        $response->assertRedirect(route('admin.espacios.index'));
        $this->assertDatabaseHas('espacios', ['nombre' => 'Nuevo Nombre']);
    }
}