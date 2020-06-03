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
            $table->boolean('editable')->default(false);
            $table->boolean('cargado')->default(false);
            $table->timestamps();
            $table->string('nombre');
            $table->string('apellido_paterno');
            $table->string('apellido_materno');
            $table->string('rut');
            $table->string('fecha_nacimiento');
            $table->string('tipo')->nullable();
            $table->string('codigo_bus')->nullable();
            $table->string('sexo');
            $table->string('telefono')->nullable();
            $table->string('email')->nullable();

            $table->unsignedBigInteger('empresa_id');
            $table->foreign('empresa_id')->references('id')->on('empresas');

            $table->unsignedBigInteger('tipo_zona_id')->nullable();
            $table->foreign('tipo_zona_id')->references('id')->on('zonas');
            $table->string('nombre_zona')->nullable();

            $table->unsignedBigInteger('tipo_via_id')->nullable();
            $table->foreign('tipo_via_id')->references('id')->on('vias');
            $table->string('nombre_via')->nullable();

            $table->string('direccion')->nullable();

            $table->unsignedBigInteger('distrito_id');
            $table->foreign('distrito_id')->references('id')->on('distritos');

            $table->unsignedBigInteger('estado_civil_id');
            $table->foreign('estado_civil_id')->references('id')->on('estado_civiles');

            $table->unsignedBigInteger('nacionalidad_id');
            $table->foreign('nacionalidad_id')->references('id')->on('nacionalidades');

            $table->unsignedBigInteger('ruta_id')->nullable();
            $table->foreign('ruta_id')->references('id')->on('rutas');

            $table->unsignedBigInteger('zona_labor_id');
            $table->foreign('zona_labor_id')->references('id')->on('zona_labores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trabajadores');
    }
}
