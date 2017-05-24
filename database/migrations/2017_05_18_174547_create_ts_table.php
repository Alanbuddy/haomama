<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->string('phone')->nullable();
            $table->enum('parenthood', ['妈妈', '爸爸']);
            $table->text('baby')->nullable()->comment('json');
//            default('{"name":"","gender":"m","birthday":"2016/01/01"}')->
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function ($table) {
            $table->dropColumn('baby');
            $table->dropColumn('parenthood');
            $table->dropColumn('phone');
        });
    }
}

