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
        Schema::create('gelir_giders', function (Blueprint $table) {
            $table->id();
            $table->enum('tip', ['gelir', 'gider'])->default('gelir');
            $table->string('baslik');
            $table->text('aciklama')->nullable();
            $table->decimal('tutar', 10, 2);
            $table->date('tarih');
            $table->string('kategori')->nullable();
            $table->foreignId('marka_id')->nullable()->constrained('markas')->onDelete('set null');
            $table->foreignId('musteri_id')->nullable()->constrained('musteris')->onDelete('set null');
            $table->foreignId('kargo_id')->nullable()->constrained('kargos')->onDelete('set null');
            $table->string('odeme_yontemi')->nullable(); // nakit, havale, cek, senet
            $table->string('fatura_no')->nullable();
            $table->text('notlar')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gelir_giders');
    }
};
