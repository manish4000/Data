<?php

use Facade\Ignition\Tabs\Tab;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsInCompanies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('email_id_1',45);
            $table->unsignedBigInteger('region_id')->nullable();
            $table->unsignedBigInteger('package_id')->nullable();
            $table->unsignedBigInteger('association_member_id')->nullable();
            $table->string('contact_1_name',100)->nullable();
            $table->string('contact_1_email',45)->nullable();
            $table->string('contact_1_designation',50)->nullable();
            $table->string('contact_1_phone',20)->nullable();
            $table->string('contact_2_name',100)->nullable();
            $table->string('contact_2_email',45)->nullable();
            $table->string('contact_2_designation',50)->nullable();
            $table->string('contact_2_phone',20)->nullable();
            $table->string('gabs_uuid',6);
            $table->string('telephone',20);
            $table->string('logo')->nullable();
            $table->string('permit_no')->nullable();
            $table->string('facebook',100)->nullable();
            $table->string('instagram',100)->nullable();
            $table->string('youtube',100)->nullable();
            $table->string('twitter',100)->nullable();
            $table->string('linkedin',100)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->enum('terms_and_services',['0','1'])->default(0);
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
}
