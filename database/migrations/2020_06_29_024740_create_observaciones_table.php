<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObservacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('observaciones', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('observacion');
            $table->string('digito')->nullable();
            $table->string('fecha')->nullable();
            $table->string('fecha_inicio')->nullable();
            $table->string('fecha_termino_c')->nullable();
            $table->boolean('contrato_activo')->default(false);
            $table->string('zona_labor_id')->nullable();
            $table->unsignedBigInteger('trabajador_id');
            $table->foreign('trabajador_id')->references('id')->on('trabajadores');
            $table->unsignedBigInteger('empresa_id');
            $table->foreign('empresa_id')->references('id')->on('empresas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('observaciones');
    }
}
