<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameRolePermissionsTableToRolePermissionsOld extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('role_permissions_old', function (Blueprint $table) {
            Schema::rename('role_permissions', 'role_permissions_old');
            $table->dropForeign('role_permissions_permission_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('role_permissions_old', function (Blueprint $table) {
            Schema::rename('role_permissions_old', 'role_permissions');
        });
    }
}
