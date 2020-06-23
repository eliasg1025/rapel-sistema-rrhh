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
            $table->date('fecha_inicio');
            $table->date('fecha_termino')->nullable();
            $table->date('fecha_termino_c')->nullable();
            $table->double('sueldo_base')->nullable();
            $table->string('codigo_bus')->nullable();
            $table->string('group')->nullable();
            $table->string('cussp')->nullable();
            $table->unsignedBigInteger('trabajador_id');
            $table->foreign('trabajador_id')->references('id')->on('trabajadores');
            $table->unsignedBigInteger('empresa_id');
            $table->foreign('empresa_id')->references('id')->on('empresas');
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
        Schema::dropIfExists('contratos');
    }
}
