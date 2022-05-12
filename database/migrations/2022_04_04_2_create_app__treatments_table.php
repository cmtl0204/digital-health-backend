<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppTreatmentsTable extends Migration
{
    public function up()
    {
        Schema::connection(env('DB_CONNECTION_APP'))->create('treatments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->foreignId('patient_id')
                ->constrained('app.patients');

            $table->json('additional_information')
                ->comment('Con la estructura {title, description}');

            $table->date('ended_at')
                ->comment('Fecha de fin del tratamiento');

            $table->date('started_at')
                ->comment('Fecha de inicio del tratamiento');

            $table->time('time_started_at')
                ->comment('Hora de inicio del tratamiento');
        });
    }

    public function down()
    {
        Schema::connection(env('DB_CONNECTION_APP'))->dropIfExists('treatments');
    }
}
