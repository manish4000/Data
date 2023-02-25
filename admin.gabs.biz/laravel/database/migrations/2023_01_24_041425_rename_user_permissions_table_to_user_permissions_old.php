<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameUserPermissionsTableToUserPermissionsOld extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_permissions_old', function (Blueprint $table) {
            Schema::rename('user_permissions', 'user_permissions_old');
            $table->dropForeign('user_permissions_permission_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_permissions_old', function (Blueprint $table) {
            Schema::rename('user_permissions_old', 'user_permissions');
        });
    }
}
