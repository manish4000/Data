<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {

            $table->string('country_name',100)->nullable();
            $table->string('state_name',100)->nullable();
            $table->string('city_name',100)->nullable();
            $table->string('region_name',100)->nullable();
            $table->string('package_name',100)->nullable();
            $table->string('association_member_name',100)->nullable();
            $table->string('marketing_status_name',100)->nullable();
            $table->string('plan_name',100)->nullable();
            $table->string('deals_in_name',100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            //
        });
    }
};
