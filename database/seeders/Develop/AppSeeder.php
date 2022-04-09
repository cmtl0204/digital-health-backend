<?php

namespace Database\Seeders\Develop;

use App\Models\App\Catalogue;
use App\Models\App\Patient;
use App\Models\Authentication\User;
use Illuminate\Database\Seeder;

class AppSeeder extends Seeder
{
    public function run()
    {
        $this->createPatients();
        $this->createSectorTypeCatalogues();
    }

    private function createPatients()
    {
        $user = User::find(3);
        $patient = new Patient();
        $patient->user()->associate($user);
        $patient->save();
    }

    private function createSectorTypeCatalogues()
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        Catalogue::factory(4)->sequence(
            [
                'name' => 'NORTE',
                'type' => $catalogues['catalogue']['sector_location']['type'],
            ],
            [
                'name' => 'CENTRO',
                'type' => $catalogues['catalogue']['sector_location']['type'],
            ],
            [
                'name' => 'SUR',
                'type' => $catalogues['catalogue']['sector_location']['type'],
            ],
            [
                'name' => 'VALLES',
                'type' => $catalogues['catalogue']['sector_location']['type'],
            ],
        )->create();
    }
}
