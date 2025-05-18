<?php

// database/migrations/xxxx_xx_xx_xxxxxx_add_category_id_to_jasas_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoryIdToJasasTable extends Migration
{
    public function up()
    {
        // Add the category_id column to jasas table
        Schema::table('jasas', function (Blueprint $table) {
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
        });
    }

    public function down()
    {
        // Remove the category_id column in case of rollback
        Schema::table('jasas', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }
}
