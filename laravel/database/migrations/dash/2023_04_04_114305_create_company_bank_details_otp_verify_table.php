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
        Schema::create('company_bank_details_otp_verify', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_user_id');
            $table->string('otp',6);
            $table->enum('verified',['0','1'])->default(0);
            $table->dateTime('create_time');
            $table->dateTime('expire_time');
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
        Schema::dropIfExists('company_bank_details_otp_verify');
    }
};
