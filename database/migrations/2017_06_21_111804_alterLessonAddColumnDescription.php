<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterLessonAddColumnDescription extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lessons', function ($table) {
            $table->text('description')->nullable();
            $table->json('extra')->nullable();
        });

        Schema::table('course_lesson', function ($table) {
            $table->integer('no')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lessons', function ($table) {
            $table->dropColumn('description');
            $table->dropColumn('extra');
        });
        Schema::table('course_lesson', function ($table) {
            $table->dropColumn('no');
        });
    }
}
