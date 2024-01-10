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
        Schema::create('produtos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo');
            $table->string('nome');
            $table->string('descricao');
            $table->string('imagem');
            $table->string('prazo_producao');
            $table->string('altura');
            $table->string('largura');
            $table->string('comprimento');
            $table->string('peso');
            $table->string('minimo');
            $table->float('valor', 8, 2);
            $table->integer('id_categoria');
            $table->integer('quantidade');
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
        Schema::dropIfExists('produtos');
    }
};
