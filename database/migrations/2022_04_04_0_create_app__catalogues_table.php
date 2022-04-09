<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppCataloguesTable extends Migration
{
    public function up()
    {
        Schema::connection(env('DB_CONNECTION_APP'))->create('catalogues', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->foreignId('parent_id')
                ->nullable()
                ->comment('Un catalogo puede tener catalogos hijos')
                ->constrained('app.catalogues');

            $table->string('code')
                ->comment('No debe ser modificado una vez que se lo crea');

            $table->text('description')
                ->nullable();

            $table->text('name');

            $table->string('type')
                ->comment('Para categorizar los catalogos');
        });
    }

    public function down()
    {
        Schema::connection(env('DB_CONNECTION_APP'))->dropIfExists('catalogues');
    }

}
