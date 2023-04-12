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
        Schema::create('companies', function (Blueprint $table) {
            $table->unsignedBigInteger('company_gabs_id');
            $table->string('gabs_uuid',6);
            $table->string('company_name',150);
            $table->string('email',150);
            $table->string('status',50);
            $table->bigInteger('city_id')->nullable();
            $table->bigInteger('state_id')->nullable();
            $table->bigInteger('country_id')->nullable();
            $table->string('skype_id', 50)->nullable();
            $table->string('website', 75)->nullable();
            $table->string('address')->nullable();
            $table->string('telephone',25)->nullable();
            $table->string('postcode', 25)->nullable();
            $table->foreign('company_gabs_id')->references('id')->on('companies_gabs')->onDelete('cascade');
            $table->softDeletes();
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
        Schema::table('companies', function (Blueprint $table) {
            //
        });
    }
};
