<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPermissionSlugTypeInCompanyMenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('company_menu_groups_menu', function (Blueprint $table) {
           $table->string('permission_slug');
           $table->enum('type',['permission','menu'])->default('menu');
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
            $table->dropColumn(['permission_slug','type']);
        });
    }
}
