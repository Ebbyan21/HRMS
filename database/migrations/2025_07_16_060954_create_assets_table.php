<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Laptop Macbook Pro 14 M3"
            $table->string('serial_number')->unique();
            $table->text('description')->nullable();
            $table->date('purchase_date')->nullable();
            $table->decimal('purchase_cost', 15, 2)->nullable();
            $table->string('status')->default('available'); // available, in_use, maintenance, retired
            $table->foreignId('assigned_to_user_id')->nullable()->constrained('users')->nullOnDelete(); // Karyawan yang memegang aset
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};