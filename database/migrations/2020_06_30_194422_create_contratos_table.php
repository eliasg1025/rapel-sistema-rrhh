<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContratosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contratos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('code')->nullable();
            $table->boolean('editable')->default(false);
            $table->boolean('cargado')->default(true);
            $table->boolean('activo')->default(true);
            $table->boolean('observado')->default(false);
            $table->string('fecha_inicio');
            $table->string('fecha_termino')->nullable();
            $table->string('fecha_termino_c')->nullable();
            $table->double('sueldo_base')->nullable();
            $table->string('codigo_bus')->nullable();
            $table->string('group')->nullable();
            $table->string('cussp')->nullable();
            $table->string('tipo_trabajador');
            $table->unsignedBigInteger('trabajador_id');
            $table->foreign('trabajador_id')->references('id')->on('trabajadores');
            $table->unsignedBigInteger('empresa_id');
            $table->foreign('empresa_id')->references('id')->on('empresas');
            $table->unsignedBigInteger('zona_labor_id');
            $table->foreign('zona_labor_id')->references('id')->on('zona_labores');
            // new
            $table->unsignedBigInteger('oficio_id');
            $table->foreign('oficio_id')->references('id')->on('oficios');
            $table->unsignedBigInteger('regimen_id');
            $table->foreign('regimen_id')->references('id')->on('regimenes');
            $table->unsignedBigInteger('actividad_id');
            $table->foreign('actividad_id')->references('id')->on('actividades');
            $table->unsignedBigInteger('cuartel_id');
            $table->foreign('cuartel_id')->references('id')->on('cuarteles');
            $table->unsignedBigInteger('agrupacion_id');
            $table->foreign('agrupacion_id')->references('id')->on('agrupaciones');
            $table->unsignedBigInteger('labor_id');
            $table->foreign('labor_id')->references('id')->on('labores');
            $table->unsignedBigInteger('tipo_contrato_id');
            $table->foreign('tipo_contrato_id')->references('id')->on('tipo_contratos');
            $table->unsignedBigInteger('ruta_id');
            $table->foreign('ruta_id')->references('id')->on('rutas');
            $table->unsignedBigInteger('troncal_id');
            $table->foreign('troncal_id')->references('id')->on('troncales');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contratos');
    }
}
