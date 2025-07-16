<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('performance_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_user_id')->constrained('users')->cascadeOnDelete(); // Karyawan yang dinilai
            $table->foreignId('reviewer_user_id')->constrained('users')->cascadeOnDelete(); // Manajer yang menilai
            $table->date('review_date'); // Tanggal penilaian
            $table->text('overall_comments')->nullable(); // Komentar umum dari manajer
            $table->string('status')->default('completed'); // Status review
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('performance_reviews');
    }
};