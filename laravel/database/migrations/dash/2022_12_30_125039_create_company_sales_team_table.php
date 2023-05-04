<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanySalesTeamTable extends Migration
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
            $table->string('name', 100)->nullable();
            $table->string('email', 45)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->string('department', 100)->nullable();
            $table->unsignedBigInteger('designation_id')->nullable();
            $table->string('designation', 100)->nullable();
            $table->string('status', 30)->nullable();
            $table->enum('two_step_verification', ['0','1'])->default(0);
            $table->string('image', 255)->nullable();
            $table->string('local_address', 250)->nullable();
            $table->unsignedBigInteger('local_country_id')->nullable();
            $table->string('local_country', 100)->nullable();
            $table->unsignedBigInteger('local_state_id')->nullable();
            $table->string('local_state', 100)->nullable();
            $table->unsignedBigInteger('local_city_id')->nullable();
            $table->string('local_city', 100)->nullable();
            $table->string('local_zip_code', 15)->nullable();
            $table->enum('same_as_local', ['0','1'])->default(0);
            $table->string('permanent_address', 250)->nullable();
            $table->unsignedBigInteger('permanent_country_id')->nullable();
            $table->string('permanent_country', 100)->nullable();
            $table->unsignedBigInteger('permanent_state_id')->nullable();
            $table->string('permanent_state', 100)->nullable();
            $table->unsignedBigInteger('permanent_city_id')->nullable();
            $table->string('permanent_city', 100)->nullable();
            $table->string('permanent_zip_code', 15)->nullable();
            $table->string('phone_1', 25)->nullable();
            $table->string('phone_2', 25)->nullable();
            $table->string('skype', 35)->nullable();
            $table->longText('language_id')->nullable();
            $table->longText('language_name')->nullable();
            $table->unsignedBigInteger('religion_id')->nullable();
            $table->string('religion', 100)->nullable();
            $table->date('anniversary_date')->nullable();
            $table->date('dob')->nullable();
            $table->enum('gender', ['male','female'])->nullable();
            $table->string('facebook', 100)->nullable();
            $table->string('instagram', 100)->nullable();
            $table->string('twitter', 100)->nullable();
            $table->string('linked_in', 100)->nullable();
            $table->string('youtube', 100)->nullable();
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
