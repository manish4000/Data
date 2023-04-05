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
        Schema::table('company_bank_details', function (Blueprint $table) {
            $table->string('branch_name')->nullable()->change();
            $table->string('branch_code')->nullable()->change();
            $table->unsignedBigInteger('country_id')->nullable()->change();
            $table->unsignedBigInteger('city_id')->nullable()->change();
            $table->unsignedBigInteger('state_id')->nullable()->change();
            $table->string('account_name',100)->nullable()->change();
            $table->string('account_address')->nullable()->change();
            $table->string('iban_no')->nullable()->change();
            $table->string('account_currency')->nullable()->change();
            $table->string('reason_for_remittance')->nullable()->change();
            $table->integer('display_order')->nullable()->change();
            $table->string('bank_address')->nullable()->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company_bank_details', function (Blueprint $table) {
            $table->string('dealer_name')->nullable(false)->change();
        });
    }
};
