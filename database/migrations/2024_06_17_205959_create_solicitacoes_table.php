<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('solicitacoes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('tipo_id'); // Adicionando a coluna tipo_id
            $table->string('titulo');
            $table->text('mensagem');
            $table->text('resposta')->nullable(); // Adicionando a coluna resposta
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('tipo_id')->references('id')->on('tipos')->onDelete('cascade'); // Definindo a chave estrangeira para tipo_id
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('solicitacoes');
    }
};
