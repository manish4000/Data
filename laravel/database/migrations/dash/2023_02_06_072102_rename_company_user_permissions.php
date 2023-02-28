<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameCompanyUserPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('company_user_permissions', function (Blueprint $table) {
            Schema::rename('company_user_permissions', 'company_user_permissions_old');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company_user_permissions', function (Blueprint $table) {
            Schema::rename('company_user_permissions_old', 'company_user_permissions');
        });
    }
}
