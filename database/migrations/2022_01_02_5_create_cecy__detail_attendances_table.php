<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCecyDetailAttendancesTable extends Migration
{
    public function up()
    {
        Schema::connection(env('DB_CONNECTION_CECY'))->create('detail_attendances', function (Blueprint $table) {
            $table->id();

            $table->foreignId('registration_id')
                ->constrained('cecy.registrations');

            $table->foreignId('attendance_id')
                ->nullable()
                ->constrained('cecy.attendances');

        });
    }

    public function down()
    {
        Schema::connection(env('DB_CONNECTION_CECY'))->dropIfExists('detail_attendances');
    }
}


