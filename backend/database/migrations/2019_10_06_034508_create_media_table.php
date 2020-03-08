<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('media_type')->nullable();
            $table->string('gallery_url')->nullable();
            $table->bigInteger('gallery_id')->nullable();
            $table->foreign('gallery_id')->references('id')->on('media');
            $table->string('canonical_url')->unique();
            $table->boolean('downloaded');
            $table->integer('download_attempts');
            $table->string('file_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media');
    }
}
