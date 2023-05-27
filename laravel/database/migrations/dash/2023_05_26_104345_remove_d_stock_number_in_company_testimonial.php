<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveDStockNumberInCompanyTestimonial extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('dash')->table('company_testimonial', function (Blueprint $table) {
            $table->dropColumn(['d_stock_number']);
            $table->unsignedBigInteger('state_id')->nullable();
            $table->string('state',50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('dash')->table('company_testimonial', function (Blueprint $table) {
            //
        });
    }
}
