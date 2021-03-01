<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->collation = 'utf8mb4_unicode_ci';
            $table->id();
            $table->string('group_name', 50)->default('User');
            $table->string('group_color', 50)->default('#FFFFFF');
            $table->smallInteger('all_perms')->default(0);
            $table->smallInteger('delete_plugin')->default(0);
            $table->smallInteger('delete_plugin_admin')->default(0);
            $table->smallInteger('create_plugin')->default(0);
            $table->smallInteger('edit_plugin')->default(0);
            $table->smallInteger('edit_plugin_admin')->default(0);
            $table->smallInteger('upload_file')->default(0);
            $table->smallInteger('upload_file_admin')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groups');
    }
}
