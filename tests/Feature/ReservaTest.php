<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\TipoEspacio;
use App\Models\Espacio;
use App\Models\Reserva;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReservaTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_reserva()
    {
        $user = User::factory()->create();
        $tipo = TipoEspacio::factory()->create();
        $espacio = Espacio::factory()->create([
            'tipo_espacio_id' => $tipo->id,
            'precio_por_hora' => 5000,
        ]);

        $data = [
            'espacio_id' => $espacio->id,
            'fecha' => Carbon::tomorrow()->format('Y-m-d'),
            'hora_inicio' => '10:00',
            'hora_fin' => '12:00',
        ];

        $response = $this->actingAs($user)->post(route('reservas.store'), $data);
        $response->assertRedirect(route('reservas.mis'));
        $this->assertDatabaseHas('reservas', [
            'espacio_id' => $espacio->id,
            'usuario_id' => $user->id,
            'precio_total' => 10000,
        ]);
    }

    public function test_cannot_overlap_reserva()
    {
        $user = User::factory()->create();
        $tipo = TipoEspacio::factory()->create();
        $espacio = Espacio::factory()->create(['tipo_espacio_id' => $tipo->id]);

        // Crear una reserva existente
        Reserva::factory()->create([
            'espacio_id' => $espacio->id,
            'usuario_id' => $user->id,
            'fecha' => '2026-07-25',
            'hora_inicio' => '10:00',
            'hora_fin' => '12:00',
            'estado' => 'pendiente',
        ]);

        $data = [
            'espacio_id' => $espacio->id,
            'fecha' => '2026-07-25',
            'hora_inicio' => '11:00',
            'hora_fin' => '13:00',
        ];

        $response = $this->actingAs($user)->post(route('reservas.store'), $data);
        $response->assertSessionHasErrors(['error']);
    }

    public function test_user_can_cancel_reserva_with_anticipation()
    {
        $user = User::factory()->create();
        $tipo = TipoEspacio::factory()->create();
        $espacio = Espacio::factory()->create(['tipo_espacio_id' => $tipo->id]);

        // Crear reserva para dentro de 3 días (más de 2 horas de anticipación)
        $reserva = Reserva::factory()->create([
            'espacio_id' => $espacio->id,
            'usuario_id' => $user->id,
            'fecha' => Carbon::now()->addDays(3)->format('Y-m-d'),
            'hora_inicio' => '10:00',
            'hora_fin' => '12:00',
            'estado' => 'pendiente',
        ]);

        $response = $this->actingAs($user)->delete(route('reservas.cancelar', $reserva));
        $response->assertRedirect();
        $this->assertDatabaseHas('reservas', [
            'id' => $reserva->id,
            'estado' => 'cancelada',
        ]);
    }

    public function test_user_cannot_cancel_reserva_without_anticipation()
    {
        $user = User::factory()->create();
        $tipo = TipoEspacio::factory()->create();
        $espacio = Espacio::factory()->create(['tipo_espacio_id' => $tipo->id]);

        // Crear reserva para dentro de 1 hora (menos de 2 horas de anticipación)
        $reserva = Reserva::factory()->create([
            'espacio_id' => $espacio->id,
            'usuario_id' => $user->id,
            'fecha' => Carbon::now()->addHour()->format('Y-m-d'),
            'hora_inicio' => Carbon::now()->addHour()->format('H:i'),
            'hora_fin' => Carbon::now()->addHours(2)->format('H:i'),
            'estado' => 'pendiente',
        ]);

        $response = $this->actingAs($user)->delete(route('reservas.cancelar', $reserva));
        $response->assertSessionHasErrors(['error']);
        $this->assertDatabaseHas('reservas', [
            'id' => $reserva->id,
            'estado' => 'pendiente',
        ]);
    }
}