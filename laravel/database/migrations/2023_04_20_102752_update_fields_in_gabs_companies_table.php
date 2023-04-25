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
            $table->unsignedBigInteger('marketing_status')->change();
            $table->longText('association_member_id')->change();
            $table->longText('deals_in')->nullable(); 
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
