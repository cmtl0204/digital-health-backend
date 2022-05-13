<?php

namespace Database\Seeders;

use Database\Seeders\Develop\AuthenticationSeeder;
use Database\Seeders\Develop\CoreSeeder;
use Database\Seeders\Develop\AppSeeder;

use Database\Seeders\Production\AuthenticationSeeder as AuthenticationSeederProd;
use Database\Seeders\Production\CoreSeeder as CoreSeederProd;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AuthenticationSeeder::class,
            AppSeeder::class
        ]);
    }
}
