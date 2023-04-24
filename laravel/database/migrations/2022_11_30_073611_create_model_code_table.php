<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelCodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('model_code', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->index();
            $table->bigInteger('parent_id')->nullable();
            $table->bigInteger('model_id')->nullable();
            $table->integer('length')->length(4)->default(0);
            $table->integer('width')->length(4)->default(0);
            $table->integer('height')->length(4)->default(0);
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
        Schema::dropIfExists('model_code');
    }
}
