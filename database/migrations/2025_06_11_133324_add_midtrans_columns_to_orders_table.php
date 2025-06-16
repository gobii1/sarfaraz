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
            // Menambahkan kolom untuk menyimpan metode pembayaran dari Midtrans
            $table->string('payment_method')->nullable()->after('payment_status');
            
            // Menambahkan kolom untuk menyimpan ID transaksi dari Midtrans
            $table->string('midtrans_transaction_id')->nullable()->after('payment_method');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'midtrans_transaction_id', 'midtrans_booking_code']);
        });
    }
};