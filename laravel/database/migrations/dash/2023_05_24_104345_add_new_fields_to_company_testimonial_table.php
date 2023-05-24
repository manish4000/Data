<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsToCompanytestimonialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('company_testimonial', function (Blueprint $table) {
            $table->string('user_image',30)->nullable();
            $table->string('buyer_image',30)->nullable();
            $table->enum('status',['Yes','No'])->default('Yes');
            $table->string('country',50);
            $table->unsignedInteger('city_id')->nullable();
            $table->string('city',50)->nullable();
            $table->string('phone',25)->nullable()->change();
            $table->dropColumn('image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company_testimonial', function (Blueprint $table) {
            //
        });
    }
}