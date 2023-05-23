<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesAgreementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_agreements', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->text('description',500)->nullable();
            $table->enum('display', ['Yes', 'No'])->default('Yes');
            $table->longText('title_languages')->nullable();   
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
        Schema::dropIfExists('sales_agreements');
    }
}
