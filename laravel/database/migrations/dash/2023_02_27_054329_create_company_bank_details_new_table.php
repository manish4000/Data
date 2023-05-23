<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyBankDetailsNewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_bank_details', function (Blueprint $table) {
            $table->id();
            $table->string('account_name', 50)->nullable();
            $table->string('account_number', 255)->nullable();
            $table->string('account_currency', 10)->nullable();
            $table->string('account_address',250)->nullable();
            $table->unsignedSmallInteger('country_id')->nullable();
            $table->string('country', 50)->nullable();
            $table->unsignedMediumInteger('state_id')->nullable();
            $table->string('state', 50)->nullable();
            $table->unsignedMediumInteger('city_id')->nullable();
            $table->string('city', 50)->nullable();
            $table->string('zip_code', 20);
            $table->enum('display', ['Yes', 'No'])->default('Yes');
            $table->enum('primary_bank', ['Yes', 'No'])->default('No');
            $table->unsignedSmallInteger('bank_name_id')->nullable();
            $table->string('bank_name', 30);
            $table->string('branch_name', 50)->nullable();
            $table->string('swift_code', 20)->nullable();
            $table->string('branch_code', 20)->nullable();
            $table->string('iban_no', 30)->nullable();
            $table->string('bank_address', 250)->nullable();
            $table->string('reason_for_remittance', 250)->nullable();
            $table->boolean('jumvea_account');
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
        Schema::dropIfExists('company_bank_details');
    }
}
