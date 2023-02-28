<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsDisplayTitleToMenuGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('menu_groups', function (Blueprint $table) {
            $table->enum("is_display_title", [ 0, 1 ])->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('menu_groups', function (Blueprint $table) {
            $table->dropColumn("is_display_title");
        });
    }
}
