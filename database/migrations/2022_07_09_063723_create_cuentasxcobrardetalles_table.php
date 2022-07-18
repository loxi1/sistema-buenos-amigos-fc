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
        Schema::create('cuentasxcobrardetalles', function (Blueprint $table) {
            $table->id();
            $table->integer('cuentaxcobrars_id');
            $table->decimal('monto_cobrado',$precision = 8, $scale = 2)->nullable();
            $table->date('fecha_ingreso');
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
        Schema::dropIfExists('cuentasxcobrardetalles');
    }
};
