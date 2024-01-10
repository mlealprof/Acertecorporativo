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
        Schema::create('preco_atacado', function (Blueprint $table) {
            $table->id();
            $table->integer('id_produto');
            $table->string('descricao')->nullable();
            $table->integer('quantidade');
            $table->float('valor', 8, 2);
            $table->float('valor_extra', 8, 2)->nullable();
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
        Schema::dropIfExists('preco_atacado');
    }
};
