<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admision', function (Blueprint $table) {
            $table->id();

            $table->text('imagen')->nullable();
            $table->string('titulo',255)->nullable();
            $table->text('descripcion')->nullable();
            $table->text('documento')->nullable();
            $table->tinyInteger('estado_tablas')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admision');
    }
};
