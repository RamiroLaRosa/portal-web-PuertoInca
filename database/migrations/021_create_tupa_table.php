<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tupa', function (Blueprint $table) {
            $table->id();

            $table->string('nombre', 255);
            $table->double('monto');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tupa');
    }
};
