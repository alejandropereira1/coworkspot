<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Espacio;
use App\Models\User;

class ReservaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'espacio_id' => Espacio::factory(),
            'usuario_id' => User::factory(),
            'fecha' => $this->faker->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
            'hora_inicio' => $this->faker->time('H:i'),
            'hora_fin' => $this->faker->time('H:i'),
            'precio_total' => $this->faker->randomFloat(2, 5000, 100000),
            'estado' => $this->faker->randomElement(['pendiente', 'confirmada', 'cancelada']),
        ];
    }
}
