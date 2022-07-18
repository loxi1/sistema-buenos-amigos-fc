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
        Schema::create('cuentaxcobrars', function (Blueprint $table) {
            $table->id();
            $table->integer('aperturaranio_id')->nullable();
            $table->integer('aperturarpartidos_id')->nullable();
            $table->integer('socios_id')->nullable();
            $table->integer('tipo_movimiento_id');
            $table->decimal('monto_cobrar',$precision = 8, $scale = 2);
            $table->decimal('monto_cobrado',$precision = 8, $scale = 2)->nullable();
            $table->decimal('monto_pendiente',$precision = 8, $scale = 2)->nullable();
            $table->integer('tipotarjeta_id')->nullable();
            $table->integer('aperturarmes_id')->nullable();
            $table->integer('asistenciapartidos_id')->nullable();
            $table->integer('cobranzaestados_id')->nullable();
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
        Schema::dropIfExists('cuentaxcobrars');
    }
};
