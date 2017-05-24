<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTermObject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('term_object', function (Blueprint $table) {
            $table->integer('term_id')->unsigned();
            $table->integer('object_id')->unsigned();
            //$table->enum('type', ['tag', 'category']);

            $table->foreign('term_id')->references('id')->on('terms')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['object_id', 'term_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('term_object');
    }
}
