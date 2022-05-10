<?php

namespace Database\Factories\App;

use App\Models\App\ClinicalHistory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClinicalHistoryFactory extends Factory
{

    protected $model = ClinicalHistory::class;

    public function definition()
    {
        return [
            'weight' => $this->faker->numberBetween(60, 65),
            'height' => 1.68,
            'waist_circumference' => $this->faker->numberBetween(50, 60),
            'neck_circumference' => $this->faker->numberBetween(40, 50),
            'percentage_body_fat' => $this->faker->numberBetween(30, 40),
            'percentage_body_water' => $this->faker->numberBetween(35, 50),
            'percentage_visceral_fat' => $this->faker->numberBetween(5, 15),
            'muscle_mass' => $this->faker->numberBetween(60, 65),
            'bone_mass' => $this->faker->numberBetween(2, 2.5),
            'metabolic_age' => $this->faker->numberBetween(50, 60),
            'basal_metabolic_rate' => $this->faker->numberBetween(300, 500),
            'total_cholesterol' => $this->faker->numberBetween(50, 100),
            'hdl_cholesterol' => $this->faker->numberBetween(40, 60),
            'ldl_cholesterol' => $this->faker->numberBetween(40, 60),
            'glucose' => $this->faker->numberBetween(70, 200),
            /* 'blood_pressure' => $this->faker->numberBetween(100, 200), */
            'heart_rate' => $this->faker->numberBetween(40, 60),
            'breathing_frequency' => $this->faker->numberBetween(40, 60),
            'is_smoke' => $this->faker->randomElement([true, false]),
            'is_diabetes' => $this->faker->randomElement([true, false]),
        ];
    }
}
