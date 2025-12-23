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
            $table->decimal('odeme_tutari', 15, 2)->nullable()->after('tutar');
            $table->decimal('kargo_ucreti', 15, 2)->nullable()->after('odeme_tutari');
            $table->string('kargo_firmasi')->nullable()->after('kargo_ucreti');
            $table->string('kargo_kodu')->nullable()->after('kargo_firmasi');
            $table->timestamp('kargolanma_tarihi')->nullable()->after('kargo_kodu');
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
