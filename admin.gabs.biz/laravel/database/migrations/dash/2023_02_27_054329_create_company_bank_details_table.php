<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyBankDetailsTable extends Migration
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
            $table->string('bank_name',);
            $table->string('dealer_name');
            $table->string('branch_name');
            $table->string('branch_code');
            $table->unsignedBigInteger('country_id');
            $table->string('account_name',100);
            $table->string('account_number',100);
            $table->string('account_address');
            $table->string('bank_address');
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('state_id');
            $table->string('swift_code',100);
            $table->string('iban_no');
            $table->string('account_currency');
            $table->string('reason_for_remittance');
            $table->unsignedInteger('display_order');
            $table->boolean('jumvea_account');
            $table->boolean('status')->default(1);
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
