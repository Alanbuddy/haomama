<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AlterLessonAddBeginEndColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lessons', function ($table) {
            $table->timestamp('begin')->nullable();
            $table->timestamp('end')->nullable();
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
            $table->dropColumn('begin');
            $table->dropColumn('end');
        });
    }
}
