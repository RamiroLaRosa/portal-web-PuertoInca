<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plana_jerarquica', function (Blueprint $table) {
            $table->id();
            
            $table->text('foto')->nullable();
            $table->string('nombre',255)->nullable();
            $table->string('cargo',255)->nullable();
            $table->tinyInteger('estado')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plana_jerarquica');
    }
};
