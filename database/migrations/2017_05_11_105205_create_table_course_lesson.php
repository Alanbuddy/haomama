<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCourseLesson extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_lesson', function (Blueprint $table) {
            $table->integer('course_id')->unsigned();
            $table->integer('lesson_id')->unsigned();

            $table->timestamps();

            $table->foreign('course_id')->references('id')->on('courses')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('lesson_id')->references('id')->on('lessons')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['lesson_id', 'course_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('course_lesson');
    }
}
