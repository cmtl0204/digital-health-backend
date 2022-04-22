<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppClinicalHistoriesTable extends Migration
{
    public function up()
    {
        Schema::connection(env('DB_CONNECTION_APP'))->create('clinical_histories', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->foreignId('patient_id')
                ->constrained('app.patients');

            $table->double('basal_metabolic_rate')
                ->nullable()
                ->comment('En kilo calorias');

            $table->double('blood_pressure')
                ->nullable()
                ->comment('En mg');

            $table->double('breathing_frequency')
                ->nullable()
                ->comment('En latidos/minutos');

            $table->double('glucose')
                ->nullable()
                ->comment('En mg/dl');

            $table->double('hdl_cholesterol')
                ->nullable()
                ->comment('En mg/dl');

            $table->double('heart_rate')
                ->nullable()
                ->comment('En latidos/minutos');

            $table->double('height')
                ->nullable()
                ->comment('En metros');

            $table->double('imc')
                ->nullable()
                ->comment('En kg/m2');

            $table->boolean('is_smoke')
                ->nullable()
                ->comment('true=si, false=no');

            $table->boolean('is_diabetes')
                ->nullable()
                ->comment('true=si, false=no');

            $table->double('ldl_cholesterol')
                ->nullable()
                ->comment('En mg/dl');

            $table->integer('metabolic_age')
                ->nullable()
                ->comment('En años');

            $table->double('neck_circumference')
                ->nullable()
                ->comment('En centimetros');

            $table->double('percentage_body_fat')
                ->nullable()
                ->comment('En porcentaje, Ej. 50');

            $table->double('percentage_body_mass')
                ->nullable()
                ->comment('En porcentaje, Ej. 50');

            $table->double('percentage_body_water')
                ->nullable()
                ->comment('En porcentaje, Ej. 50');

            $table->double('percentage_bone_mass')
                ->nullable()
                ->comment('En porcentaje, Ej. 50');

            $table->double('percentage_visceral_fat')
                ->nullable()
                ->comment('En porcentaje, Ej. 50');

            $table->date('registered_at')
                ->nullable()
                ->comment('Fecha de registro');

            $table->double('total_cholesterol')
                ->nullable()
                ->comment('En mg/dl');

            $table->double('waist_circumference')
                ->nullable()
                ->comment('En centimetros');

            $table->double('weight')
                ->nullable()
                ->comment('En kilogramos');
        });
    }

    public function down()
    {
        Schema::connection(env('DB_CONNECTION_APP'))->dropIfExists('clinical_histories');
    }
}
