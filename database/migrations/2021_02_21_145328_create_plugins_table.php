<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePluginsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plugins', function (Blueprint $table) {
            $table->collation = 'utf8mb4_unicode_ci';
            $table->id();
            $table->string('name', 50)->default('Example Plugin');
            $table->string('image_url', 150)->default('https://github.com/galaxy119/EXILED/raw/master/assets/Exiled_Icon.jpg');
            $table->string('small_description', 250)->default('Plugin small description');
            $table->string('description', 2000)->default('Plugin description');
            $table->string('wiki_url', 250)->default('');
            $table->string('issues_url', 250)->default('');
            $table->string('source_url', 250)->default('');
            $table->bigInteger('latest_file_id')->default(-1);
            $table->string('latest_exiled_version', 10)->default('');
            $table->string('latest_version', 10)->default('1.0.0');
            $table->dateTime('last_update')->nullable();
            $table->dateTime('creation_date')->nullable();
            $table->bigInteger('downloads_count')->default(0);
            $table->unsignedBigInteger('category')->unsigned()->default(1)->index();
            $table->foreign('category')->references('id')->on('plugins_categories')->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plugins');
    }
}
