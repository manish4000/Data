<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            
            $table->id();
            $table->unsignedSmallInteger('company_id')->nullable();
            $table->string('title',5);
            $table->string('name',100);
            $table->string('company_name',100);
            $table->string('customer_uid',10);
            $table->string('email_1',50);
            $table->string('password',20);
            $table->string('email_2',50)->nullable();
            $table->string('mobile_1',25);
            $table->string('messenger_1')->nullable();
            $table->string('mobile_2',25)->nullable();
            $table->string('messenger_2')->nullable();
            $table->enum('dealer_type',['Dealer','Buyer'])->nullable();
            $table->enum('member_login',['Yes','No'])->nullable();
            $table->enum('broker', ['Yes', 'No'])->nullable();
            $table->string('address',250)->nullable();
            $table->unsignedInteger('city_id')->nullable();
            $table->string('city',50)->nullable();
            $table->unsignedInteger('state_id')->nullable();
            $table->string('state',50)->nullable();
            $table->unsignedInteger('country_id')->nullable();
            $table->string('country',50)->nullable();
            $table->unsignedInteger('port_id')->nullable();
            $table->string('port',30)->nullable();
            $table->string('zip_code',10)->nullable();
            $table->unsignedInteger('religion_id')->nullable();
            $table->string('religion',30)->nullable();
            $table->unsignedInteger('nationality_id')->nullable();
            $table->string('nationality',50)->nullable();
            $table->date('birth_date')->nullable();
            $table->date('anniversary_date')->nullable();
            $table->text('social_media')->nullable();
            $table->unsignedInteger('sales_person_id')->nullable();
            $table->string('sales_person',50)->nullable();
            $table->unsignedInteger('rating_id')->nullable();
            $table->string('rating',20)->nullable();
            $table->unsignedInteger('stage_id')->nullable();
            $table->string('stage',30)->nullable();
            $table->unsignedInteger('terms_id')->nullable();
            $table->string('terms',20)->nullable();
            $table->date('next_follow_up_date')->nullable();
            $table->string('admin_memo',250)->nullable();
            $table->unsignedInteger('currency_id')->nullable();
            $table->string('currency',5)->nullable();
            $table->unsignedBigInteger('opening_balance')->nullable();
            $table->date('opening_balance_date')->nullable();
            $table->enum('opening_balance_type', ['Debit', 'Credit'])->nullable();
            $table->string('user_image',30)->nullable();
            $table->string('visiting_card_img',30)->nullable();
            $table->string('company_logo',30)->nullable();
            $table->integer('storage_days')->nullable();
            $table->unsignedBigInteger('credit_limit')->nullable();
            $table->integer('bid_limitations')->nullable();
            $table->unsignedBigInteger('bid_amount_limit')->nullable();
            $table->string('bid_limit_reason',100)->nullable();
            $table->integer('intial_payment_due_days')->nullable();
            $table->enum('bid',['Yes','No'])->nullable();
            $table->enum('bid_mail',['Yes','No'])->nullable();
            $table->enum('sales_statistics',['Yes','No'])->nullable();
            $table->enum('auction',['Yes','No'])->nullable();
            $table->enum('uss',['Yes','No'])->nullable();
            $table->integer('uss_images')->nullable();
            $table->date('registration_date')->nullable();
            $table->enum('registered_by', ['Sales', 'Client']);
            $table->string('registered_ip',50)->nullable();
            $table->unsignedInteger('registered_by_user_id')->nullable();
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
        Schema::dropIfExists('clients');
    }
}
