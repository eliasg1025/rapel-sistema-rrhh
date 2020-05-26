<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRutasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rutas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');

            $table->unsignedBigInteger('tronca_id');
            $table->foreign('tronca_id')->references('id')->on('troncas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rutas');
    }
}
