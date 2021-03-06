<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppResultsTable extends Migration
{
    public function up()
    {
        Schema::connection(env('DB_CONNECTION_APP'))->create('results', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->foreignId('patient_id')
                ->constrained('app.patients');
        });
    }

    public function down()
    {
        Schema::connection(env('DB_CONNECTION_APP'))->dropIfExists('results');
    }
}
