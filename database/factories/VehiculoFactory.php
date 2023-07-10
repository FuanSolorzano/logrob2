<?php

namespace Database\Factories;

use App\Models\Vehiculo;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class VehiculoFactory extends Factory
{
    protected $model = Vehiculo::class;

    public function definition()
    {
        return [
			'marca' => $this->faker->name,
			'modelo' => $this->faker->name,
			'color' => $this->faker->name,
			'estado' => $this->faker->name,
			'categoria_id' => $this->faker->name,
			'user_id' => $this->faker->name,
        ];
    }
}
