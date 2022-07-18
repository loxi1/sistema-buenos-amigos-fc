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
        Schema::create('listaganadores', function (Blueprint $table) {
            $table->id();
            $table->integer('aperturaranio_id');
            $table->integer('aperturarmes_id');
            $table->integer('aperturarpartidos_id');
            $table->integer('asistenciapartidos_id');
            $table->integer('socios_id');
            $table->decimal('monto_ganado',$precision = 8, $scale = 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('listaganadores');
    }
};
