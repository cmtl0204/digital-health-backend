<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppPatientsTable extends Migration
{
    public function up()
    {
        Schema::connection(env('DB_CONNECTION_APP'))->create('patients', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->foreignId('sector_id')
                ->nullable()
                ->constrained('core.catalogues');

            $table->foreignId('user_id')
                ->constrained('authentication.users');
        });
    }

    public function down()
    {
        Schema::connection(env('DB_CONNECTION_APP'))->dropIfExists('patients');
    }

}
