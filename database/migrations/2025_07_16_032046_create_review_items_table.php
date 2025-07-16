<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('review_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('performance_review_id')->constrained('performance_reviews')->cascadeOnDelete();
            $table->foreignId('kpi_id')->constrained('kpis')->cascadeOnDelete();
            $table->integer('rating'); // Skor, misal 1-5
            $table->text('comments')->nullable(); // Komentar spesifik untuk KPI ini
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('review_items');
    }
};