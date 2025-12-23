<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rol_yetki', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rol_id')->constrained('rols')->onDelete('cascade');
            $table->foreignId('yetki_id')->constrained('yetkis')->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['rol_id', 'yetki_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rol_yetki');
    }
};
