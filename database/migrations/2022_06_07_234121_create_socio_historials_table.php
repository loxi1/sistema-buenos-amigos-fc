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
        Schema::create('socio_historials', function (Blueprint $table) {
            $table->id();
            $table->integer('socio_id');
            $table->integer('persona_id');
            $table->integer('tiposocios_id');
            $table->integer('aperturaranio_id')->nullable();
            $table->date('fecha_ingreso')->useCurrent();
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
        Schema::dropIfExists('socio_historials');
    }
};
