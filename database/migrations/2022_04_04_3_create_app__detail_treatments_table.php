<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppDetailTreatmentsTable extends Migration
{
    public function up()
    {
        Schema::connection(env('DB_CONNECTION_APP'))->create('detail_treatments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->foreignId('treatment_id')
                ->constrained('app.treatments');

            $table->string('food')
                ->comment('No debe ser modificado una vez que se lo crea');

            $table->string('unit')
                ->comment('Unidad de medida ejmplo kg, metros, etc');

            $table->string('amount')
                ->comment('Cantidad de comida ejemplo 1/2, 1, 300,');

            $table->foreignId('type_id')
                ->comment('Si es desayuno, almuerzo, merienda, etc')
                ->constrained('app.catalogues');

            $table->time('started_at')
                ->comment('Hora del tratamiento');
        });
    }

    public function down()
    {
        Schema::connection(env('DB_CONNECTION_APP'))->dropIfExists('detail_treatments');
    }
}
