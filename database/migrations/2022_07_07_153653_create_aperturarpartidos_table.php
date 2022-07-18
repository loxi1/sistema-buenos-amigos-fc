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
        Schema::create('aperturarpartidos', function (Blueprint $table) {
            $table->id();
            $table->integer('aperturarmes_id')->nullable();
            $table->date('fecha_partido')->nullable();
            $table->decimal('monto_recaudado',$precision = 8, $scale = 2)->nullable();
            $table->decimal('monto_para_club',$precision = 8, $scale = 2)->nullable();
            $table->decimal('monto_para_apuesta',$precision = 8, $scale = 2)->nullable();
            $table->integer('arbitro_id')->nullable();
            $table->decimal('pago_arbitraje',$precision = 8, $scale = 2)->nullable();
            $table->integer('cancha_id')->nullable();
            $table->decimal('pago_cancha',$precision = 8, $scale = 2)->nullable();
            $table->decimal('cantidad_horas',$precision = 8, $scale = 2)->nullable();
            $table->integer('user_id')->nullable();
            $table->timestamps();
            $table->enum('estado',['Pendiente','Jugando','Finalizo'])->default('Pendiente');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aperturarpartidos');
    }
};
