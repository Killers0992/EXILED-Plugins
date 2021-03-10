<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePluginsMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plugins_members', function (Blueprint $table) {
            $table->collation = 'utf8mb4_unicode_ci';
            $table->id();
            $table->unsignedBigInteger('steamid')->unsigned()->index();
            $table->foreign('steamid')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('plugin_id')->unsigned()->index();
            $table->foreign('plugin_id')->references('id')->on('plugins')->onDelete('cascade');
            $table->unsignedBigInteger('group')->unsigned()->index();
            $table->foreign('group')->references('id')->on('plugins_groups')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plugins_members');
    }
}
