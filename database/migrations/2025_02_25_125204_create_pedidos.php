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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->string('numero');
            $table->string('id_bling');
            $table->string('id_loja');
            $table->string('cliente');
            $table->string('status');
            $table->date('data_compra');
            $table->date('data_envio')->nullable();
            $table->string('obs')->nullable();          
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
        Schema::dropIfExists('_pedidos');
    }
};
