<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string("username", 50)->unique();
            $table->enum("user_type", [ "Admin", "Company", "Staff"])->default("Admin");
            $table->string("plan_type", 15)->nullable();
            $table->enum("update_company_profile", [ "Yes", "No" ])->default("No");
            $table->string("encrypt_string", 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn("username");
            $table->dropColumn("user_type");
            $table->dropColumn("plan_type");
            $table->dropColumn("update_company_profile");
            $table->dropColumn("encrypt_string");
        });
    }
}
