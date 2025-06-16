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
        Schema::table('orders', function (Blueprint $table) {
            // Tambahkan kolom 'user_order_number' sebagai integer
            // Ini akan menyimpan nomor urut pesanan untuk user tertentu
            $table->integer('user_order_number')->nullable()->after('user_id');

            // Opsional: Buat indeks unik gabungan jika Anda ingin memastikan
            // kombinasi user_id dan user_order_number selalu unik
            // $table->unique(['user_id', 'user_order_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Hapus kolom 'user_order_number' jika migrasi di-rollback
            $table->dropColumn('user_order_number');
        });
    }
};