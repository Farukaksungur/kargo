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
        Schema::create('kargos', function (Blueprint $table) {
            $table->id();
            $table->string('takip_no')->unique();
            $table->string('alici_ad')->nullable();
            $table->string('durum')->default('hazirlaniyor'); // hazirlaniyor, yolda, teslim_edildi
            $table->timestamp('hazirlanma_tarihi')->nullable();
            $table->timestamp('yola_cikis_tarihi')->nullable();
            $table->timestamp('teslim_tarihi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kargos');
    }
};
