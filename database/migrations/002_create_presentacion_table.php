<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('presentacion', function (Blueprint $table) {
            $table->id();
            
            $table->text('imagen')->nullable();
            $table->string('titulo',255)->nullable();
            $table->text('foto_director',255)->nullable();
            $table->string('nombre_director',255)->nullable();
            $table->text('palabras_director')->nullable();
            $table->tinyInteger('estado')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('presentacion');
    }
};
