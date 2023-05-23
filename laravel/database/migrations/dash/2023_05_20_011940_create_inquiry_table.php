<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInquiryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inquiry', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('company_id')->nullable();
            $table->string('stock_number', 30)->nullable();
            $table->string('type', 30)->nullable();
            $table->string('subtype', 30)->nullable();
            $table->string('make', 30)->nullable();
            $table->string('model', 30)->nullable();
            $table->string('model_code', 10)->nullable();
            $table->string('chassis_no', 30)->nullable();
            $table->unsignedSmallInteger('fuel_id')->length()->nullable();
            $table->string('fuel', 40)->nullable();
            $table->unsignedSmallInteger('transmission_id')->nullable();
            $table->string('transmission', 50)->nullable();
            $table->unsignedTinyInteger('year_from')->nullable();
            $table->unsignedInteger('year_to')->nullable();
            $table->string('mileage', 10)->nullable();
            $table->unsignedSmallInteger('terms_id')->nullable();
            $table->string('terms', 50)->nullable();
            $table->string('budget', 10)->nullable();
            $table->string('currency', 10)->nullable();
            $table->Text('customer_message')->nullable();
            $table->string('name', 50);
            $table->string('email', 50);
            $table->unsignedMediumInteger('country_id')->nullable();
            $table->string('country', 50)->nullable();
            $table->unsignedMediumInteger('port_id')->nullable();
            $table->string('port', 30)->nullable();
            $table->unsignedInteger('purchase_capacity')->nullable();
            $table->enum('customer_type', ['Buyer','Dealer'])->default('Buyer');
            $table->string('phone', 20)->nullable();
            $table->string('messenger', 500)->nullable();
            $table->date('next_contact_date')->nullable();
            $table->Text('admin_memo')->nullable();
            $table->unsignedSmallInteger('rating_id')->nullable();
            $table->string('rating', 30)->nullable();
            $table->unsignedInteger('source_id')->nullable();
            $table->string('source', 50)->nullable();
            $table->unsignedInteger('stage_id')->nullable();
            $table->string('stage', 50)->nullable();
            $table->unsignedInteger('sales_person_id')->nullable();
            $table->string('sales_person', 100)->nullable();
            $table->date('inquiry_date')->nullable();
            $table->Text('dealer_comment')->nullable();
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
        Schema::dropIfExists('inquiry');
    }
}
