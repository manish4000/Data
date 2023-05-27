<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHsCodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('dash')->create('hs_code', function (Blueprint $table) {
            $table->id();
            $table->string('name',20)->nullable();
            $table->smallInteger('fuel_id')->nullable();
            $table->string('fuel',50)->nullable();
            $table->smallInteger('type_id')->nullable();
            $table->string('type',50)->nullable();
            $table->string('engine_cc',5)->nullable();
            $table->smallInteger('year')->nullable();
            $table->string('carrying_capacity_kg',10)->nullable();
            $table->string('gross_weight_kg',10)->nullable();
            $table->text('admin_memo',500)->nullable();
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
        Schema::dropIfExists('hs_code');
    }
}
