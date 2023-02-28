<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveUniqueInCompanyMenuGroupMenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('company_menu_groups_menu', function (Blueprint $table) {
            // $table->string('slug')->unique(false)->change();
            $table->dropUnique(['slug']); 

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company_menu_groups_menu', function (Blueprint $table) {
            //
        });
    }
}
