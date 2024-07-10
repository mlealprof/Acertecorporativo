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
        Schema::create('produtos_fornecedor', function (Blueprint $table) {
            $table->id();
            $table->string('cod_fornecedor');            
            $table->string('cod_cor');
            $table->string('imagem_link');
            $table->string('nome');
            $table->string('cor');
            $table->string('preco');
            $table->string('ponta_estoque');
            $table->string('estoque');
            $table->string('StatusConfiabilidade');
            $table->string('reposicao');
            

            
            

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
        Schema::dropIfExists('produtos_fornecedor');
    }
};
