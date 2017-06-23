<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('from')->unsigned()->nullable();
            $table->integer('to')->unsigned()->nullable()->comment('The id of user who should receive this message');
            $table->integer('object_id')->unsigned()->nullable()->comment('The id of something which is related to this message');
            $table->string('object_type')->nullable();
            $table->boolean('has_read')->default(false);
            $table->text('content')->nullable();
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
        Schema::dropIfExists('messages');
    }
}
