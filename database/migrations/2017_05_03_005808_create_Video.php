<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cloud_file_id')->nullable()->comment('腾讯云视频文件ID');
            $table->string('file_name')->nullable()->comment('文件名');
            $table->string('mime')->nullable()->comment('文件MIME类型');
            $table->string('extension')->nullable()->comment('文件扩展名');
            $table->bigInteger('size')->nullable();
            $table->string('description')->nullable();
            $table->string('path')->nullable();
            $table->enum('video_type', ['common', 'compound'])->nullable()->comment('视频类型，普通视频和合成的视频');;
//            $table->timestamp('created_at')->nullable();
            $table->timestamps();
            $table->integer('user_id')->unsigned()->comment('创建文件的用户ID');

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('files');
    }
}
