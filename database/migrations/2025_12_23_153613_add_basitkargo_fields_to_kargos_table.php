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
            $table->string('basitkargo_id')->nullable()->after('teslim_tarihi');
            $table->string('basitkargo_barcode')->nullable()->after('basitkargo_id');
            $table->string('basitkargo_handler_code')->nullable()->after('basitkargo_barcode');
            $table->text('basitkargo_tracking_link')->nullable()->after('basitkargo_handler_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kargos', function (Blueprint $table) {
            $table->dropColumn([
                'basitkargo_id',
                'basitkargo_barcode',
                'basitkargo_handler_code',
                'basitkargo_tracking_link',
            ]);
        });
    }
};
