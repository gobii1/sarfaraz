<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orders_id')->constrained()->onDelete('cascade'); // Relasi dengan tabel 'orders'
            $table->foreignId('products_id')->constrained()->onDelete('cascade'); // Relasi dengan tabel 'products'
            $table->integer('quantity');
            $table->decimal('price', 10, 2); // Menyimpan harga per unit
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}
