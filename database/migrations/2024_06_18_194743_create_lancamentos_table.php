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
            $table->id();
            $table->string('codigo')->nullable();
            $table->string('valor')->nullable();
            $table->unsignedBigInteger('user_id')->nullable(); // Assuming user_id is unsigned big integer
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('moeda_id')->nullable(); // Assuming moeda_id is unsigned big integer
            $table->foreign('moeda_id')->references('id')->on('moedas')->onDelete('cascade');
            $table->unsignedBigInteger('status_id')->nullable(); // Assuming status_id is unsigned big integer
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('cascade');
            $table->unsignedBigInteger('tipo_id')->nullable(); // Assuming tipo_id is unsigned big integer
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
