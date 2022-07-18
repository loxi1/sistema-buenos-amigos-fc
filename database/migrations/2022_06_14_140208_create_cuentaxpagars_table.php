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
        Schema::create('cuentaxpagars', function (Blueprint $table) {
            $table->id();
            $table->integer('aperturarpartidos_id')->nullable();
            $table->integer('tipo_movimiento_id')->nullable();
            $table->decimal('monto_pagar',$precision = 8, $scale = 2);
            $table->decimal('monto_pagado',$precision = 8, $scale = 2)->nullable();
            $table->decimal('monto_pendiente',$precision = 8, $scale = 2)->nullable();
            $table->integer('pagoestados_id')->nullable();
            $table->date('fecha_ingreso')->nullable();
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
        Schema::dropIfExists('cuentaxpagars');
    }
};
