<?php

namespace Database\Factories\App;

use App\Models\App\Catalogue;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $types = Catalogue::where('type', 'PRODUCT_TYPE')->get();
        return [
            'type_id' => $this->faker->randomElement($types),
            'carbohydrates' => $this->faker->randomFloat(1, 0.1, 10),
            'gross_weight' => $this->faker->numberBetween(50, 150),
            'energy' => $this->faker->numberBetween(40, 140),
            'lipids' => $this->faker->randomFloat(1, 0.1, 3),
            'name' => $this->faker->word(),
            'net_weight' => $this->faker->numberBetween(40, 140),
            'quantity' => $this->faker->randomElement(['1', '2', '3', '1/2']),
            'protein' => $this->faker->randomFloat(1, 0.1, 3),
            'unit' => $this->faker->randomElement(['kg','g','taza']),
        ];
    }
}
