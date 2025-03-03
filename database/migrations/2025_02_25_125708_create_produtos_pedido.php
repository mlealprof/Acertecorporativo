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
        Schema::create('produtos_pedido', function (Blueprint $table) {
            $table->id();
            $table->int('id_pedido');
            $table->int('id_ordem');
            $table->int('quantidade');
            $table->string('produto');
            $table->string('cor');
            $table->string('personalizacao');
            $table->string('tecnica');
            $table->string('obs')->nullable();
            $table->string('status');
            $table->string('sku');
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
        Schema::dropIfExists('_produtos_pedido');
    }
};
