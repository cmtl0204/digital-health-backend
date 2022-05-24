<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppProductsTable extends Migration
{
    public function up()
    {
        Schema::connection(env('DB_CONNECTION_APP'))->create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->foreignId('type_id')
                ->constrained('app.catalogues');


            $table->double('ascorbic_acid')
                ->nullable();

            $table->double('carbohydrates')
                ->nullable();

            $table->double('energy')
                ->nullable();

            $table->double('fiber')
                ->nullable();

            $table->double('folic_acid')
                ->nullable();

            $table->double('glycemic_index')
                ->nullable();

            $table->double('glycemic_load')
                ->nullable();

            $table->double('gross_weight')
                ->nullable();

            $table->double('iron')
                ->nullable();

            $table->double('lipids')
                ->nullable();

            $table->string('name')
                ->comment('');

            $table->double('net_weight')
                ->nullable();

            $table->double('potassium')
                ->nullable();

            $table->double('protein')
                ->nullable();

            $table->string('quantity')
                ->nullable();

            $table->string('unit');

            $table->double('vitamin_a')
                ->nullable();
        });

    }

    public function down()
    {
        Schema::connection(env('DB_CONNECTION_APP'))->dropIfExists('products');
    }

}
