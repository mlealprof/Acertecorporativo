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
            $table->longText('descricao')->nullable();;
            $table->string('imagem');
            $table->string('prazo_producao')->nullable();;
            $table->string('altura')->nullable();;
            $table->string('largura')->nullable();;
            $table->string('comprimento')->nullable();;
            $table->string('peso')->nullable();;
            $table->string('minimo')->nullable();;
            $table->float('valor', 8, 2)->nullable();;
            $table->integer('id_categoria');
            $table->integer('id_tipo');
            $table->integer('quantidade')->nullable();;
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
