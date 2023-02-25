<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique()->index();
            $table->string('phone_code', 10)->nullable();
            $table->string('country_code', 5)->nullable();
            $table->string('currency', 5)->nullable();
            $table->string('currency_symbol', 10)->nullable();
            $table->bigInteger('regions_id')->nullable();
            $table->string('region', 30)->nullable();
            $table->enum('as_from', ['Yes', 'No'])->default('No');
            $table->enum('display', ['Yes', 'No'])->default('Yes');
            $table->bigInteger('parent_id')->nullable();
            $table->bigInteger('jct_ref_id')->nullable();
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
        Schema::dropIfExists('countries');
    }
}
