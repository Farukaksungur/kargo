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
        Schema::create('islem_logus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('islem_tipi'); // create, update, delete, view, login, logout
            $table->string('modul'); // markalar, musteriler, kargolar, faturalar, etc.
            $table->string('tablo')->nullable();
            $table->unsignedBigInteger('kayit_id')->nullable();
            $table->text('aciklama')->nullable();
            $table->string('ip_adresi')->nullable();
            $table->text('eski_deger')->nullable(); // JSON
            $table->text('yeni_deger')->nullable(); // JSON
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('islem_logus');
    }
};
