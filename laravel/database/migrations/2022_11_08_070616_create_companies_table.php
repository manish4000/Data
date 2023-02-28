<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('name', 255)->index();
            $table->bigInteger('dealer_type_id')->nullable();
            $table->string('short_name', 255)->index();
            $table->string('status', 255)->nullable();
            $table->bigInteger('membership_type_id')->nullable();            
            $table->string('address', 255)->nullable();
            $table->string('postcode', 25)->nullable();
            $table->bigInteger('city_id')->nullable();
            $table->bigInteger('state_id')->nullable();
            $table->bigInteger('country_id')->nullable();
            $table->string('skype_id', 50)->nullable();
            $table->json('language_id')->nullable();
            $table->json('organization_id')->nullable();
            $table->string('website_prefix', 10)->default('https://');
            $table->string('website', 75)->nullable();
            $table->bigInteger('ownership_type_id')->nullable();
            $table->json('payment_term_id')->nullable();
            $table->string('year_established', 4)->nullable();
            $table->string('number_of_staffs', 75)->nullable();
            $table->string('office_timing', 100)->nullable();
            $table->string('holidays', 155)->nullable();
            $table->json('deals_in_id')->nullable();
            $table->json('business_type_id')->nullable();
            $table->json('service_id')->nullable();
            $table->text('dealer_permit_number')->nullable();
            $table->enum('display', ['Yes', 'No'])->default('Yes');
            $table->bigInteger('jct_ref_id')->nullable();
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
        Schema::dropIfExists('companies');
    }
}
