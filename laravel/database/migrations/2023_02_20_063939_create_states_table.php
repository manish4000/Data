<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('states', function (Blueprint $table) {

            $table->id('id');
            $table->string('name');
            $table->unsignedBigInteger('country_id');
            $table->char('country_code',2);
            $table->string('fips_code')->nullable()->default('NULL');
            $table->string('iso2')->nullable()->default('NULL');
            $table->string('type',191)->nullable()->default('NULL');
            $table->decimal('latitude',11 ,8)->nullable();
            $table->decimal('longitude',11,8)->nullable();
            $table->tinyInteger('flag')->default(1);
            $table->string('wikiDataId')->nullable()->default('NULL');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->enum('display',['Yes','No'])->default('Yes');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
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
        Schema::dropIfExists('states');
    }
}
