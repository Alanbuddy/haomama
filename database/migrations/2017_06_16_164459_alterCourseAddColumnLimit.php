<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCourseAddColumnLimit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('courses', function ($table) {
            $table->integer('quota')->nullable()->comment('人数限额');
            $table->float('original_price', 10, 2)->default(0.00)->nullable()->comment('原价，金额单位为【元】');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('courses', function ($table) {
            $table->dropColumn('quota');
            $table->dropColumn('original_price');
        });
    }
}

