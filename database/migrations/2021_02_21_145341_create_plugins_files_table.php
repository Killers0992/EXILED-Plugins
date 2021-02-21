<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePluginsFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plugins_files', function (Blueprint $table) {
            $table->collation = 'utf8mb4_unicode_ci';
            $table->id('file_id');
            $table->bigInteger('plugin_id')->default(0);
            $table->smallInteger('type')->default(0);
            $table->string('file_name', 50)->default('Unknown name');
            $table->string('file_extension', 50)->default('dll');
            $table->bigInteger('file_size')->default(0);
            $table->dateTime('upload_time')->nullable();
            $table->string('exiled_version', 10)->default('');
            $table->string('version', 10)->default('1.0.0');
            $table->bigInteger('downloads_count')->default(0);
            $table->string('changelog', 1000)->default('No changelog');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plugins_files');
    }
}
