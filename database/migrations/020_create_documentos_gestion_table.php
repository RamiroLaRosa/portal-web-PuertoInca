<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documentos_gestion', function (Blueprint $table) {
            $table->id();

            $table->text('imagen')->nullable();
            $table->string('nombre',255)->nullable();
            $table->text('documento')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documentos_gestion');
    }
};
