<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosTable extends Migration
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

            $table->integer('numero');
            $table->enum('tipo', ['SE', 'RM']);
            $table->date('dataChegada');
            $table->string('secretariaSolicitante');
            $table->string('projeto');
            $table->text('descricao');
            $table->date('dataEnvioFinanceiro')->nullable();
            $table->date('dataRetornoFinanceiro')->nullable();
            $table->string('situacaoAutorizacao')->nullable();
            $table->text('observacoes')->nullable();

            $table->timestamps();

            $table->unique(['numero', 'tipo']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pedidos');
    }
}
