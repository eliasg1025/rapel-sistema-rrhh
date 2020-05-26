<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrabajadoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trabajadores', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nombre');
            $table->string('apellido_paterno');
            $table->string('apellido_materno');
            $table->string('rut');
            $table->string('fecha_nacimiento');
            $table->boolean('tipo');
            $table->string('codigo_bus')->nullable();
            $table->boolean('sexo');
            $table->string('telefono')->nullable();
            $table->string('email')->nullable();

            $table->string('nombre_zona')->nullable();
            $table->string('nombre_via')->nullable();

            $table->unsignedBigInteger('distrito_id');
            $table->foreign('distrito_id')->references('id')->on('distritos');

            $table->unsignedBigInteger('estado_civil_id');
            $table->foreign('estado_civil_id')->references('id')->on('estado_civiles');

            $table->unsignedBigInteger('nacionalidad_id');
            $table->foreign('nacionalidad_id')->references('id')->on('nacionalidades');

            $table->unsignedBigInteger('grupo_id');
            $table->foreign('grupo_id')->references('id')->on('grupos');

            $table->unsignedBigInteger('ruta_id');
            $table->foreign('ruta_id')->references('id')->on('rutas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trabajadors');
    }
}
