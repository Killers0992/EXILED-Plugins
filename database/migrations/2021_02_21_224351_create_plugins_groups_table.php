<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePluginsGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plugins_groups', function (Blueprint $table) {
            $table->collation = 'utf8mb4_unicode_ci';
            $table->id();
            $table->string('group_name')->default('');
            $table->string('group_color')->default('#FFFFFF');
            $table->smallInteger('all_perms')->default(0);
            $table->smallInteger('edit_plugin')->default(0);
            $table->smallInteger('upload_file')->default(0);
        });
        DB::table('plugins_groups')->insert(
            array(
                'id' => 5,
                'group_name' => 'Owner',
                'all_perms' => 1
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
        Schema::dropIfExists('plugins_groups');
    }
}
