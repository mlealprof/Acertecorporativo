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
        Schema::create('ponto', function (Blueprint $table) {
            $table->id();
            $table->integer('id_funcionario');
            $table->date('data');
            $table->time('entrada');
            $table->time('saida_almoco');
            $table->time('entrada_almoco');
            $table->time('saida');
            $table->time('atrazo_entrada');
            $table->time('hora_extra_entrada');
            $table->time('atrazo_almoco');
            $table->time('hora_extra_almoco');
            $table->time('antes_saida');
            $table->time('hora_extra_saida');
            $table->string('imagem')->nullable();
            $table->string('Atestado');

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
        Schema::dropIfExists('ponto');
    }
};
