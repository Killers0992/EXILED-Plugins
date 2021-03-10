<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePluginsDownloadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plugins_downloads', function (Blueprint $table) {
            $table->string('ip', 255);
            $table->unsignedBigInteger('plugin_id')->unsigned()->index();
            $table->foreign('plugin_id')->references('id')->on('plugins')->onDelete('cascade');
            $table->bigInteger('file_id')->default(-1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plugins_downloads');
    }
}
