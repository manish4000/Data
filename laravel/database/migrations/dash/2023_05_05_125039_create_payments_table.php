<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->enum('payment_status', ['Yes', 'No']);
            $table->date('cash_in_date');
            $table->string('payment_ref_no',100);
            $table->unsignedBigInteger('receiving_bank')->nullable();
            $table->string('amount',20);
            $table->unsignedBigInteger('currency');
            $table->string('ex_rate',10);
            $table->string('eq_in_accounting_currency',20);
            $table->bigInteger('balance_amount')->nullable();
            $table->bigInteger('refund_amount')->nullable();
            $table->date('refund_date')->nullable();
            $table->string('client_id',20)->nullable();
            $table->string('customer_name',100)->nullable();
            $table->string('depositer_name',100)->nullable();
            $table->unsignedBigInteger('payment_mode')->nullable();
            $table->string('payment_receipt',255)->nullable();
            $table->string('memo',250)->nullable();
            $table->string('note_for_accounting',250)->nullable();
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
        Schema::dropIfExists('payments');
    }
}
