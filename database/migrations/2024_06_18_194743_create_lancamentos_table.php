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
        Schema::create('lancamentos', function (Blueprint $table) {
            $table->bigIncrements('id')->change();
            $table->string('codigo')->nullable();
            $table->string('valor')->nullable();
            $table->integer('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('moeda_id')->nullable();
            $table->foreign('moeda_id')->references('id')->on('moedas')->onDelete('cascade');
            $table->integer('status_id')->nullable();
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('cascade');
            $table->integer('tipo_id')->nullable();
            $table->foreign('tipo_id')->references('id')->on('tipos')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lancamentos');
    }
};
