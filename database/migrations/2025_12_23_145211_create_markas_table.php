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
        Schema::create('markas', function (Blueprint $table) {
            $table->id();
            $table->string('ad')->unique();
            $table->string('firma_adi')->nullable();
            $table->string('telefon')->nullable();
            $table->string('email')->nullable();
            $table->text('adres')->nullable();
            $table->decimal('toplam_borc', 15, 2)->default(0);
            $table->decimal('odenen_tutar', 15, 2)->default(0);
            $table->decimal('kalan_tutar', 15, 2)->default(0);
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
        Schema::dropIfExists('markas');
    }
};
