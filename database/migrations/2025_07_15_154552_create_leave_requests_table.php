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
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Siapa yang mengajukan
            $table->date('start_date'); // Tanggal mulai cuti
            $table->date('end_date');   // Tanggal selesai cuti
            $table->text('reason');     // Alasan cuti
            $table->string('status')->default('pending'); // Status: pending, approved, rejected
            $table->foreignId('approved_by')->nullable()->constrained('users'); // Siapa yg approve/reject
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_requests');
    }
};