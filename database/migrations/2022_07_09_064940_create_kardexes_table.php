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
        Schema::create('kardexes', function (Blueprint $table) {
            $table->id();
            $table->integer('tipomovimientos_id');
            $table->enum('tipo',['Ingreso','Salida'])->default('Ingreso');
            $table->string('abreviatura')->nullable();
            $table->integer('documento_id');
            $table->decimal('monto',$precision = 8, $scale = 2)->nullable();
            $table->decimal('saldo_actual',$precision = 8, $scale = 2)->nullable();
            $table->timestamps();
            $table->enum('estado',['Activo','Cancelado'])->default('Activo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kardexes');
    }
};
