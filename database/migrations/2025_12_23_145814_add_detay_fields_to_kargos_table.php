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
        Schema::table('kargos', function (Blueprint $table) {
            $table->string('alici_soyad')->nullable()->after('alici_ad');
            $table->string('alici_telefon')->nullable()->after('alici_soyad');
            $table->string('il')->nullable()->after('alici_telefon');
            $table->string('ilce')->nullable()->after('il');
            $table->text('adres')->nullable()->after('ilce');
            $table->text('urun_bilgisi')->nullable()->after('adres');
            $table->decimal('tutar', 15, 2)->nullable()->after('urun_bilgisi');
            $table->text('notlar')->nullable()->after('tutar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kargos', function (Blueprint $table) {
            //
        });
    }
};
