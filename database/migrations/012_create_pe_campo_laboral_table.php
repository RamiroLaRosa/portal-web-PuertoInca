<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pe_campo_laboral', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('programa_estudio_id');
            $table->text('imagen')->nullable();
            $table->text('texto')->nullable();

            $table->foreign('programa_estudio_id')->references('id')->on('programas_estudios');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pe_campo_laboral');
    }
};
