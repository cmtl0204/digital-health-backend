<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppReferenceValuesTable extends Migration
{
    public function up()
    {
        Schema::connection(env('DB_CONNECTION_APP'))->create('reference_values', function (Blueprint $table) {
            $table->id();

            $table->string('code')
                ->nullable()
                ->comment('');

            $table->enum('sex', ['MALE', 'FEMALE'])
                ->nullable()
                ->comment('');

            $table->integer('age_min')
                ->nullable()
                ->comment('');

            $table->integer('age_max')
                ->nullable()
                ->comment('');

            $table->float('weight_min')
                ->nullable()
                ->comment('');

            $table->float('weight_max')
                ->nullable()
                ->comment('');

            $table->float('value_min')
                ->nullable()
                ->comment('');

            $table->float('value_max')
                ->nullable()
                ->comment('');

            $table->string('interpretation')
                ->nullable()
                ->comment('');

            $table->integer('level')
                ->nullable()
                ->comment('');

        });
    }

    public function down()
    {
        Schema::connection(env('DB_CONNECTION_APP'))->dropIfExists('reference_values');
    }
}
