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
        Schema::table('jasas', function (Blueprint $table) {
            // Tambahkan kolom 'gallery_images' sebagai JSON atau string nullable
            // Jika ingin menyimpan multiple path, disarankan JSON
            $table->json('gallery_images')->nullable()->after('image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jasas', function (Blueprint $table) {
            // Hapus kolom 'gallery_images' jika migrasi di-rollback
            $table->dropColumn('gallery_images');
        });
    }
};