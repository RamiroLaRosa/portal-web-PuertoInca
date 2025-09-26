<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('adm_resultados', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('admision_id');
            $table->unsignedBigInteger('programa_estudio_id');
            $table->text('documento')->nullable();
            $table->tinyInteger('estado')->nullable();

            $table->foreign('admision_id')->references('id')->on('admision');
            $table->foreign('programa_estudio_id')->references('id')->on('programas_estudios');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('adm_resultados');
    }
};
