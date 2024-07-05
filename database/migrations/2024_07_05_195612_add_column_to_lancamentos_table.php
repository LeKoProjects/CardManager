<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('lancamentos', function (Blueprint $table) {
            $table->integer('solicitacao_id')->nullable();
            $table->foreign('solicitacao_id')->references('id')->on('solicitacoes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lancamentos', function (Blueprint $table) {
            //
        });
    }
};
