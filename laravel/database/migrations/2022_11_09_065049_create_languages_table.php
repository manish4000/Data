<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique()->index();
            $table->string('caption', 75)->nullable();
            $table->string('alias', 5)->nullable();
            $table->enum('for_web', ['Yes', 'No'])->default('No');
            $table->enum('display', ['Yes', 'No'])->default('Yes');
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
        Schema::dropIfExists('languages');
    }
}
