<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoPicture extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_attachment', function (Blueprint $table) {
            $table->integer('video_id')->unsigned();
            $table->integer('attachment_id')->unsigned();
            $table->enum('type',['picture','audio']);

            $table->foreign('video_id')->references('id')->on('files')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('attachment_id')->references('id')->on('files')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['video_id', 'attachment_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('video_attachment');
    }
}
