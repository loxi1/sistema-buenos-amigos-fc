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
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            $table->string('nombres',60);
            $table->string('apellidos',70);
            $table->enum('sexo',['Hombre','Mujer','No definido'])->default('Hombre');
            $table->integer('tipo_documentos_id')->nullable();
            $table->string('numero_documento',12)->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->integer('celular')->nullable();
            $table->integer('departamentos_id')->nullable();
            $table->integer('provincias_id')->nullable();
            $table->integer('distritos_id')->nullable();
            $table->text('direccion')->nullable();
            $table->text('referencia')->nullable();
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
        Schema::dropIfExists('personas');
    }
};
