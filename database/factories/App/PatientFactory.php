<?php

namespace Database\Factories\App;

use App\Models\App\Catalogue;
use App\Models\App\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

class PatientFactory extends Factory
{

    protected $model = Patient::class;

    public function definition()
    {
        $sectors = Catalogue::where('type', 'SECTOR_LOCATION')->get();
        return [
            'sector_id' => $this->faker->randomElement($sectors),
        ];
    }
}
