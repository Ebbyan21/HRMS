<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('salary_components', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // e.g., "Gaji Pokok", "Tunjangan Transport"
            $table->enum('type', ['allowance', 'deduction']); // Jenis: Tunjangan atau Potongan
            $table->boolean('is_fixed')->default(true); // Apakah nominalnya tetap untuk semua?
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('salary_components');
    }
};