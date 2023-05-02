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
        Schema::table('companies_gabs', function (Blueprint $table) {
            $table->string('country_name',100)->nullable();
            $table->string('state_name',100)->nullable();
            $table->string('city_name',100)->nullable();
            $table->string('region_name',100)->nullable();
            $table->string('package_name',100)->nullable();
            $table->longText('association_member_name')->nullable();
            $table->string('marketing_status_name',100)->nullable();
            $table->string('plan_name',100)->nullable();
            $table->longText('deals_in_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies_gabs', function (Blueprint $table) {
            //
        });
    }
};
