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
        Schema::table('clicks', function (Blueprint $table) {
            $table->string('full_url')->nullable(); // Полный URL
            $table->string('userAgent')->nullable(); // User-Agent пользователя
            $table->json('target')->nullable(); // JSON-поле для хранения данных о целевом элементе
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clicks', function (Blueprint $table) {
            $table->dropColumn(['full_url', 'userAgent', 'target']);
        });
    }
};
