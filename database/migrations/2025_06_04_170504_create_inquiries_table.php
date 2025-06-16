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
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable(); // Nomor telepon bisa opsional
            $table->foreignId('jasa_id')->nullable()->constrained('jasas')->onDelete('set null'); // Relasi ke jasa
            $table->text('message');
            $table->boolean('is_read')->default(false); // Untuk menandai inquiry sudah dibaca admin
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};