<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShowInCaptionAndShowInMasterInsiteLanguages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('site_languages', function (Blueprint $table) {
            $table->boolean('show_in_captions')->default('0');
            $table->boolean('show_in_masters')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('site_languages', function (Blueprint $table) {
            //
        });
    }
}
