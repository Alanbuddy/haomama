<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterFiles extends Migration
{
    public function up()
    {
        Schema::table('files', function ($table) {
            $table->text('caption')->nullable()->comment('字幕');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('files', function ($table) {
            $table->dropColumn('caption');
        });
    }
}
