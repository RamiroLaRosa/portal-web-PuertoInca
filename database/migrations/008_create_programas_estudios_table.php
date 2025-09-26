<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('programas_estudios', function (Blueprint $table) {
            $table->id();
            
            $table->string('nombre',255)->nullable();
            $table->text('imagen')->nullable();
            $table->text('logo')->nullable();
            $table->string('duracion',255)->nullable();
            $table->string('modalidad',255)->nullable();
            $table->string('turno',255)->nullable();
            $table->string('horarios',255)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('programas_estudios');
    }
};
