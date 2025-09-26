<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pe_egresado', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('programa_estudio_id');
            $table->text('foto')->nullable();
            $table->string('nombre',255)->nullable();
            $table->text('descripcion')->nullable();

            $table->foreign('programa_estudio_id')->references('id')->on('programas_estudios');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pe_egresado');
    }
};
