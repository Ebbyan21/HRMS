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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel users, WAJIB ADA
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');

            // Info Pekerjaan
            $table->string('job_title');
            $table->string('department');
            $table->date('hire_date');

            // Info Pribadi (boleh null/kosong)
            $table->string('phone_number')->nullable();
            $table->text('address')->nullable();

            $table->timestamps(); // Kolom created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
