<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['payment_status', 'snap_token']);
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_status')->default('pending');
            $table->string('snap_token')->nullable();
        });
    }
};
