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
        Schema::create('clicks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('site_id'); // ID сайта (FK)
            $table->foreign('site_id')->references('id')->on('sites')->onDelete('cascade');
            $table->decimal('x', 8, 2);            // Координата X
            $table->decimal('y', 8, 2);            // Координата Y
            $table->timestamp('timestamp');        // Время клика
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clicks');
    }
};
