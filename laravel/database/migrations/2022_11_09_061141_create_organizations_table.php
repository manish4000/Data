<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->index();
            $table->string('abbreviation_name', 255)->index();
            $table->bigInteger('organization_type_id');
            $table->string('jct_page_url_prefix', 10)->nullable();
            $table->string('jct_page_url', 255)->nullable();
            $table->string('website_prefix', 10)->nullable();
            $table->string('website', 75)->nullable();
            $table->string('email', 255)->index();
            $table->string('person_name', 255)->index();
            $table->longText('description')->nullable();
            $table->string('logo', 255)->nullable();
            $table->enum('display', ['Yes', 'No'])->default('Yes');
            $table->enum('send_enquiry', ['Yes', 'No'])->default('Yes');
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
        Schema::dropIfExists('organizations');
    }
}
