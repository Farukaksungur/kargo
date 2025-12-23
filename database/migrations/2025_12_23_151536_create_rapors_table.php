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
        Schema::create('rapors', function (Blueprint $table) {
            $table->id();
            $table->string('ad');
            $table->string('tip'); // satis, kargo, finansal, musteri, marka
            $table->date('baslangic_tarihi');
            $table->date('bitis_tarihi');
            $table->json('parametreler')->nullable(); // Rapor parametreleri
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->text('aciklama')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rapors');
    }
};
