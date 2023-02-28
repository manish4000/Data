<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDealInsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deal_ins', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique()->index();
            $table->enum('display', ['Yes', 'No'])->default('Yes');
            $table->bigInteger('jct_ref_id')->nullable();
            $table->bigInteger('parent_id')->nullable();
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
        Schema::dropIfExists('deal_ins');
    }
}
