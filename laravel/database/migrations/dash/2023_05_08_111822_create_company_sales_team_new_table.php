<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanySalesTeamNewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_sales_team', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('company_user_id')->nullable();
            $table->enum('status', ['Yes','No'])->default('Yes');
            $table->enum('verification', ['0','1'])->default(0);
            $table->enum('title', ['mr','mrs','ms'])->nullable();
            $table->string('name', 100);
            $table->string('email', 45);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->unsignedBigInteger('department_id')->nullable();
            $table->string('department', 100)->nullable();
            $table->unsignedBigInteger('designation_id')->nullable();
            $table->string('designation', 100)->nullable();
            $table->string('image', 255)->nullable();
            $table->string('company_address', 250)->nullable();
            $table->unsignedBigInteger('company_country_id')->nullable();
            $table->string('company_country', 100)->nullable();
            $table->unsignedBigInteger('company_state_id')->nullable();
            $table->string('company_state', 100)->nullable();
            $table->unsignedBigInteger('company_city_id')->nullable();
            $table->string('company_city', 100)->nullable();
            $table->string('company_zip_code', 15)->nullable();
            $table->string('company_phone', 25)->nullable();
            $table->longText('company_messenger_id')->nullable();
            $table->longText('company_messenger_name')->nullable();
            $table->longText('language_id')->nullable();
            $table->longText('language_name')->nullable();
            $table->string('current_address', 250)->nullable();
            $table->unsignedBigInteger('current_country_id')->nullable();
            $table->string('current_country', 100)->nullable();
            $table->unsignedBigInteger('current_state_id')->nullable();
            $table->string('current_state', 100)->nullable();
            $table->unsignedBigInteger('current_city_id')->nullable();
            $table->string('current_city', 100)->nullable();
            $table->string('current_zip_code', 15)->nullable();
            $table->enum('same_as_current', ['0','1'])->default(0);
            $table->string('permanent_address', 250)->nullable();
            $table->unsignedBigInteger('permanent_country_id')->nullable();
            $table->string('permanent_country', 100)->nullable();
            $table->unsignedBigInteger('permanent_state_id')->nullable();
            $table->string('permanent_state', 100)->nullable();
            $table->unsignedBigInteger('permanent_city_id')->nullable();
            $table->string('permanent_city', 100)->nullable();
            $table->string('permanent_zip_code', 15)->nullable();
            $table->string('personal_phone', 25)->nullable();
            $table->longText('personal_messenger_id')->nullable();
            $table->longText('personal_messenger_name')->nullable();
            $table->unsignedBigInteger('religion_id')->nullable();
            $table->string('religion', 100)->nullable();
            $table->date('anniversary_date')->nullable();
            $table->date('dob')->nullable();
            $table->longText('company_social_media')->nullable();
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
        Schema::dropIfExists('company_sales_team');
    }
}
