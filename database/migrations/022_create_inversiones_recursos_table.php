<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inversiones_recursos', function (Blueprint $table) {
            $table->id();

            $table->string('titulo',255)->nullable();
            $table->text('imagen')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inversiones_recursos');
    }
};
