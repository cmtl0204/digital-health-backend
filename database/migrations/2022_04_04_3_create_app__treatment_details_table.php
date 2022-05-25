<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppTreatmentDetailsTable extends Migration
{
    public function up()
    {
        Schema::connection(env('DB_CONNECTION_APP'))->create('treatment_details', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->foreignId('treatment_id')
                ->constrained('app.treatments');

            $table->foreignId('product_id')
                ->constrained('app.products');

            $table->foreignId('type_id')
                ->comment('Si es desayuno, almuerzo, merienda, etc')
                ->constrained('app.catalogues');

            $table->string('unit')
                ->comment('Unidad de medida ejmplo kg, metros, etc');

            $table->string('quantity')
                ->comment('Cantidad de comida ejemplo 1/2, 1, 300,');

            $table->dateTime('time_started_at')
                ->nullable()
                ->comment('Hora del tratamiento');
        });
    }

    public function down()
    {
        Schema::connection(env('DB_CONNECTION_APP'))->dropIfExists('treatment_details');
    }
}
