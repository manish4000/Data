<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanySalesTeamNewAddTable extends Migration
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
            $table->unsignedSmallInteger('company_id')->nullable();
            $table->unsignedSmallInteger('company_user_id')->nullable();
            $table->enum('status', ['Yes','No'])->default('Yes');
            $table->enum('verification', ['0','1'])->default(0);
            $table->enum('title', ['mr','mrs','ms'])->nullable();
            $table->string('name', 50);
            $table->string('email', 50);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->unsignedSmallInteger('department_id')->nullable();
            $table->string('department', 50)->nullable();
            $table->unsignedSmallInteger('designation_id')->nullable();
            $table->string('designation', 50)->nullable();
            $table->string('image', 150)->nullable();
            $table->string('roles_id', 250)->nullable();
            $table->string('roles', 250)->nullable();
            $table->Text('admin_memo')->nullable();
            $table->string('company_address', 250)->nullable();
            $table->unsignedSmallInteger('company_country_id')->nullable();
            $table->string('company_country', 50)->nullable();
            $table->unsignedSmallInteger('company_state_id')->nullable();
            $table->string('company_state', 50)->nullable();
            $table->unsignedSmallInteger('company_city_id')->nullable();
            $table->string('company_city', 50)->nullable();
            $table->string('company_zip_code', 15)->nullable();
            $table->string('company_phone', 25)->nullable();
            $table->string('company_messenger', 500)->nullable();
            $table->string('language_id', 100)->nullable();
            $table->string('language_name', 200)->nullable();
            $table->string('current_address', 250)->nullable();
            $table->unsignedSmallInteger('current_country_id')->nullable();
            $table->string('current_country', 50)->nullable();
            $table->unsignedSmallInteger('current_state_id')->nullable();
            $table->string('current_state', 50)->nullable();
            $table->unsignedSmallInteger('current_city_id')->nullable();
            $table->string('current_city', 50)->nullable();
            $table->string('current_zip_code', 15)->nullable();
            $table->enum('same_as_current', ['0','1'])->default(0);
            $table->string('permanent_address', 250)->nullable();
            $table->unsignedSmallInteger('permanent_country_id')->nullable();
            $table->string('permanent_country', 50)->nullable();
            $table->unsignedSmallInteger('permanent_state_id')->nullable();
            $table->string('permanent_state', 50)->nullable();
            $table->unsignedSmallInteger('permanent_city_id')->nullable();
            $table->string('permanent_city', 50)->nullable();
            $table->string('permanent_zip_code', 15)->nullable();
            $table->string('personal_phone', 25)->nullable();
            $table->string('personal_messenger', 500)->nullable();
            $table->unsignedSmallInteger('religion_id')->nullable();
            $table->string('religion', 50)->nullable();
            $table->date('anniversary_date')->nullable();
            $table->date('dob')->nullable();
            $table->Text('company_social_media')->nullable();
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
