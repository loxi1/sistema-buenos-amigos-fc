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
        Schema::create('asistenciapartidos', function (Blueprint $table) {
            $table->id();
            $table->integer('aperturarpartidos_id')->nullable();
            $table->integer('socios_id');
            $table->enum('es_ganador',['No','Si'])->default('No');
            $table->timestamps();
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
        Schema::dropIfExists('asistenciapartidos');
    }
};
