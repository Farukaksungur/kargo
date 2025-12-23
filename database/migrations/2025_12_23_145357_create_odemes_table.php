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
        Schema::create('odemes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('marka_id')->constrained('markas')->onDelete('cascade');
            $table->decimal('tutar', 15, 2);
            $table->date('odeme_tarihi');
            $table->string('odeme_tipi')->default('nakit'); // nakit, havale, cek, senet
            $table->string('aciklama')->nullable();
            $table->string('fatura_no')->nullable();
            $table->text('notlar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('odemes');
    }
};
