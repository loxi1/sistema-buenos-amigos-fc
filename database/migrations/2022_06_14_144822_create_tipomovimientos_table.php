<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipomovimientos', function (Blueprint $table) {
            $table->id();
            $table->string('tipomovimientos')->nullable();
            $table->string('abreviatura')->nullable();
            $table->integer('padre_id')->nullable();
            $table->enum('tipo',['Ingreso','Salida',''])->default('');
            $table->enum('estado',['Activo','Inactivo'])->default('Activo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipomovimientos');
    }
};
