<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\TipoEspacio;

class EspacioFactory extends Factory
{
    public function definition(): array
    {
        return [
            'tipo_espacio_id' => TipoEspacio::factory(),
            'nombre' => $this->faker->unique()->words(2, true),
            'capacidad' => $this->faker->numberBetween(1, 10),
            'precio_por_hora' => $this->faker->randomFloat(2, 1000, 50000),
            'piso' => $this->faker->numberBetween(1, 5),
            'activo' => true,
            'image' => null,
        ];
    }
}