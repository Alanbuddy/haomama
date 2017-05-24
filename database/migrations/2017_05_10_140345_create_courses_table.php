<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('teacher_id')->unsigned()->nullable()->comment('老师ID');
            $table->integer('category_id')->unsigned()->nullable()->comment('分类ID');
            $table->string('cover')->nullable()->comment('课程封面图片URL');
            $table->float('price', 10, 2)->default(0.00)->nullable()->comment('价格，金额单位为【元】');
            $table->string('address')->nullable()->comment('线下课程授课地址');
            $table->enum('type', ['online', 'offline'])->comment('课程种类:线上和线下');;
            $table->enum('status', ['publish', 'draft'])->comment('课程状态:发布，未发布');;
            $table->timestamp('begin')->nullable();
            $table->timestamp('end')->nullable();
            $table->text('description')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('courses');
    }
}
