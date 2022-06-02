<?php

namespace Database\Seeders;

use Database\Seeders\Develop\AuthenticationSeeder;
use Database\Seeders\Develop\AppSeeder;
use Database\Seeders\Production\AuthenticationSeeder as AuthenticationSeederProd;
use Database\Seeders\Production\AppSeeder as AppSeederProd;
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
        if (env('SEEDER_ENV') != 'local') {
            $this->call([
                AuthenticationSeederProd::class,
                AppSeederProd::class
            ]);
        } else {
            $this->call([
                AuthenticationSeeder::class,
                AppSeeder::class
            ]);
        }
    }
}
