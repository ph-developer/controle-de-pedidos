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

            $table->string('numero', 10);
            $table->enum('tipo', ['SE', 'RM']);
            $table->date('dataChegada');
            $table->string('secretariaSolicitante', 100);
            $table->string('projeto', 100);
            $table->text('descricao');
            $table->date('dataEnvioFinanceiro')->nullable();
            $table->date('dataRetornoFinanceiro')->nullable();
            $table->string('situacaoAutorizacao', 50)->nullable();
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
