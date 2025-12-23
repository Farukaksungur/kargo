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
        Schema::create('faturas', function (Blueprint $table) {
            $table->id();
            $table->string('fatura_no')->unique();
            $table->enum('tip', ['satis', 'alis', 'iade'])->default('satis');
            $table->date('tarih');
            $table->date('vade_tarihi')->nullable();
            $table->foreignId('marka_id')->nullable()->constrained('markas')->onDelete('set null');
            $table->foreignId('musteri_id')->nullable()->constrained('musteris')->onDelete('set null');
            $table->foreignId('kargo_id')->nullable()->constrained('kargos')->onDelete('set null');
            $table->decimal('ara_toplam', 10, 2)->default(0);
            $table->decimal('kdv_orani', 5, 2)->default(18);
            $table->decimal('kdv_tutari', 10, 2)->default(0);
            $table->decimal('genel_toplam', 10, 2);
            $table->enum('durum', ['beklemede', 'odendi', 'iptal'])->default('beklemede');
            $table->string('odeme_yontemi')->nullable();
            $table->text('notlar')->nullable();
            $table->json('urunler')->nullable(); // JSON formatında ürün listesi
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faturas');
    }
};
