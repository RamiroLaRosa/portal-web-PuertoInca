<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            
            $table->string('codigo',20)->unique();
            $table->string('password',100);
            $table->string('nombre',255);
            $table->string('correo',255)->nullable();
            $table->string('celular',20)->nullable();
            $table->tinyInteger('estado')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};


