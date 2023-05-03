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
            $table->enum('status', ['Active', 'Deactive']);
            $table->string('title',5);
            $table->string('name',100);
            $table->string('company_name',100);
            $table->bigInteger('customer_uid');
            $table->string('password');
            $table->string('email_1',45);
            $table->string('email_2',45)->nullable();
            $table->string('mobile_1',20);
            $table->string('mobile_2',20)->nullable();
            // $table->string('skype',35)->nullable();
            $table->string('address',250)->nullable();
            $table->unsignedBigInteger('city')->nullable();
            $table->unsignedBigInteger('state')->nullable();
            $table->unsignedBigInteger('country');
            $table->unsignedBigInteger('port')->nullable();
            $table->string('zip_code',15)->nullable();
            $table->unsignedBigInteger('religion')->nullable();
            $table->unsignedBigInteger('nationality')->nullable();
            $table->date('birth_date')->nullable();
            $table->date('anniversary_date')->nullable();
            $table->string('facebook',100)->nullable();
            $table->string('instagram',100)->nullable();
            $table->string('twitter',100)->nullable();
            $table->string('linked_in',100)->nullable();
            $table->string('sales_person')->nullable();
            $table->unsignedBigInteger('rating')->nullable();
            $table->unsignedBigInteger('stage')->nullable();
            $table->unsignedBigInteger('term')->nullable();
            $table->enum('broker', ['Yes', 'No'])->nullable();
            $table->date('next_follow_up_date')->nullable();
            $table->string('opening_balance',20)->nullable();
            $table->date('opening_balance_date')->nullable();
            $table->enum('opening_balance_type', ['Debit', 'Credit']);
            $table->unsignedBigInteger('currency')->nullable();
            $table->string('visiting_card_img')->nullable();
            $table->string('admin_memo',250)->nullable();
            $table->date('registration_date')->nullable();
            $table->enum('registered_by', ['Sales', 'Client']);
            $table->string('registered_ip',50)->nullable();
            $table->unsignedBigInteger('registered_by_usre_id')->nullable();
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
