<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppFraminghamTablesTable extends Migration
{
    public function up()
    {
        Schema::connection(env('DB_CONNECTION_APP'))->create('framingham_tables', function (Blueprint $table) {
            $table->id();

            $table->string('code')
                ->nullable()
                ->comment('');

            $table->enum('gender', ['MALE', 'FEMALE'])
                ->nullable()
                ->comment('');

            $table->float('value_min')
                ->nullable()
                ->comment('');

            $table->float('value_max')
                ->nullable()
                ->comment('');

            $table->string('score')
                ->nullable()
                ->comment('');
        });
    }

    public function down()
    {
        Schema::connection(env('DB_CONNECTION_APP'))->dropIfExists('framingham_tables');
    }
}
