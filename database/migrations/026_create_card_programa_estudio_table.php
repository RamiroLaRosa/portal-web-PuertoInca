<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('card_programa_estudio', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('programa_estudio_id');
            $table->date('fecha')->nullable();
            $table->text('imagen')->nullable();
            $table->string('titulo',255)->nullable();
            $table->text('descripcion')->nullable();

            $table->foreign('programa_estudio_id')->references('id')->on('programas_estudios');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('card_programa_estudio');
    }
};
