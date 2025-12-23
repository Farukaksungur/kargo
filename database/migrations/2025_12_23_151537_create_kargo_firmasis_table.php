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
        Schema::create('kargo_firmasis', function (Blueprint $table) {
            $table->id();
            $table->string('ad');
            $table->string('kod')->unique();
            $table->string('telefon')->nullable();
            $table->string('email')->nullable();
            $table->string('web_sitesi')->nullable();
            $table->text('adres')->nullable();
            $table->decimal('varsayilan_ucret', 8, 2)->default(0);
            $table->boolean('aktif')->default(true);
            $table->text('notlar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kargo_firmasis');
    }
};
