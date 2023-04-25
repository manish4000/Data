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
        Schema::table('companies_gabs', function (Blueprint $table) {
            $table->string('contact_1_name',100)->nullable();
            $table->string('contact_1_email',50)->nullable();
            $table->string('contact_1_designation',50)->nullable();
            $table->string('contact_1_phone',20)->nullable();

            $table->enum('contact_1_viber',['0','1'])->default('0');
            $table->enum('contact_1_line',['0','1'])->default('0');
            $table->enum('contact_1_whatsapp',['0','1'])->default('0');

            $table->string('contact_2_name',100)->nullable();
            $table->string('contact_2_email',50)->nullable();
            $table->string('contact_2_designation',50)->nullable();
            $table->string('contact_2_phone',20)->nullable();

            $table->enum('contact_2_viber',['0','1'])->default('0');
            $table->enum('contact_2_line',['0','1'])->default('0');
            $table->enum('contact_2_whatsapp',['0','1'])->default('0');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies_gabs', function (Blueprint $table) {
           
        });
    }
};
