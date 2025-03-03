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
        Schema::create('funcionarios', function (Blueprint $table) {
            $table->id();
            $table->string('email')->nullable();;
            $table->string('nome');
            $table->string('cpf');
            $table->string('senha');
            $table->date('Dt_admissao');
            $table->float('Valor_Vale')->nullable();
            $table->float('salario');
            $table->float('bonificacao')->nullable();
            $table->integer('plano_saude');
            $table->float('valor_plano')->nullable();
            $table->float('valor_descontar')->nullable();
            $table->float('saldo_plano')->nullable();
            $table->integer('porcentagem_plano')->nullable();
            $table->string('pix')->nullable();
            $table->string('obs')->nullable();
            $table->string('periodo');

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
        Schema::dropIfExists('funcionarios');
    }
};
