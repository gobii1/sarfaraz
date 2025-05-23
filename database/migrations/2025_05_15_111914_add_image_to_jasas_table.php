<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('jasas', function (Blueprint $table) {
        $table->string('image')->nullable();  // Menambahkan kolom untuk menyimpan path gambar
    });
}

public function down()
{
    Schema::table('jasas', function (Blueprint $table) {
        $table->dropColumn('image');  // Menghapus kolom gambar jika rollback
    });
}

};
