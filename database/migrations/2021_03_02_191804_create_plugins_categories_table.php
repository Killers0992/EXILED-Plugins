<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePluginsCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plugins_categories', function (Blueprint $table) {
            $table->collation = 'utf8mb4_unicode_ci';
            $table->id();
            $table->string('category_name', 50)->default('None');
            $table->string('category_color', 50)->default('');
        });
        DB::table('plugins_categories')->insert(
            array(
                'id' => 0,
                'category_name' => 'None',
                'category_color' => 'gray'
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plugins_categories');
    }
}
