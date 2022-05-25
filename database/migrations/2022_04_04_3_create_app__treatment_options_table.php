<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppTreatmentOptionsTable extends Migration
{
    public function up()
    {
        Schema::connection(env('DB_CONNECTION_APP'))->create('treatment_options', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->foreignId('treatment_detail_id')
                ->constrained('app.treatment_details');

            $table->foreignId('product_id')
                ->constrained('app.products');

            $table->string('unit')
                ->comment('Unidad de medida ejmplo kg, metros, etc');

            $table->string('quantity')
                ->comment('Cantidad de comida ejemplo 1/2, 1, 300,');
        });
    }

    public function down()
    {
        Schema::connection(env('DB_CONNECTION_APP'))->dropIfExists('treatment_options');
    }
}
