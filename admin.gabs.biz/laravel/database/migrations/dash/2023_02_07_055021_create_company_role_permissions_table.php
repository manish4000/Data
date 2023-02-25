<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyRolePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_role_permissions', function (Blueprint $table) {
            $table->unsignedBigInteger('company_role_id');
            $table->unsignedBigInteger('company_menu_id');
            $table->foreign('company_menu_id')->references('id')->on('company_menu_groups_menu')->onDelete('cascade');
            $table->primary(['company_role_id','company_menu_id']);
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
        Schema::dropIfExists('company_role_permissions');
    }
}
