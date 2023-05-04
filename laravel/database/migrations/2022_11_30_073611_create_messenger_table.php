<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessengerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messenger', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique()->index();
            $table->string('url')->nullable();
            $table->string('logo')->nullable();
            $table->bigInteger('parent_id')->nullable();
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
        Schema::dropIfExists('messenger');
    }
}
