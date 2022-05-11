<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColaboradorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Colaborador', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('nombreCompleto');
            $table->string('puesto')->nullable();
            $table->string('correo')->nullable();
            $table->date('fechaCumpleanios')->nullable();
            $table->date('fechaIngreso')->nullable();
            $table->string('jefeInmediato')->nullable();
            $table->string('correoJefeInmediato')->nullable();
            $table->string('director')->nullable();
            $table->string('correoDirector')->nullable();
			$table->integer('fecha_excel')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Colaborador');
    }
}
