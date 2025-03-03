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
        Schema::create('historico_producao', function (Blueprint $table) {
            $table->id();
            $table->int('id_ordem');
            $table->string('descricao');
            $table->int('id_funcionario');
            $table->string('situacao');
            $table->date('data');
            $table->time('hora');
            $table->int('qt_feita');
            $table->string('obs');
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
        Schema::dropIfExists('historico_producao');
    }
};
