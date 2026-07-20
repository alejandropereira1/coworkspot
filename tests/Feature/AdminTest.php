<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\TipoEspacio;
use App\Models\Espacio;
use App\Models\Reserva;
use Illuminate\Foundation\Testing\RefreshDatabase;


class AdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_panel()
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get('/admin/panel');
        $response->assertStatus(200);
    }

    public function test_member_cannot_access_admin_panel()
    {
        $member = User::factory()->create(['role' => 'member']);

        $response = $this->actingAs($member)->get('/admin/panel');
        $response->assertStatus(403);
    }

    public function test_admin_can_confirm_reserva()
    {
        $admin = User::factory()->admin()->create();
        $tipo = TipoEspacio::factory()->create();
        $espacio = Espacio::factory()->create(['tipo_espacio_id' => $tipo->id]);
        $reserva = Reserva::factory()->create([
            'espacio_id' => $espacio->id,
            'usuario_id' => User::factory()->create()->id,
            'estado' => 'pendiente',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.reservas.confirmar', $reserva));
        $response->assertRedirect();
        $this->assertDatabaseHas('reservas', [
            'id' => $reserva->id,
            'estado' => 'confirmada',
        ]);
    }

    public function test_admin_can_cancel_any_reserva()
    {
        $admin = User::factory()->admin()->create();
        $tipo = TipoEspacio::factory()->create();
        $espacio = Espacio::factory()->create(['tipo_espacio_id' => $tipo->id]);
        $reserva = Reserva::factory()->create([
            'espacio_id' => $espacio->id,
            'usuario_id' => User::factory()->create()->id,
            'estado' => 'pendiente',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.reservas.cancelar', $reserva));
        $response->assertRedirect();
        $this->assertDatabaseHas('reservas', [
            'id' => $reserva->id,
            'estado' => 'cancelada',
        ]);
    }
}