<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupportLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('support_languages', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique()->index();
            $table->bigInteger('parent_id')->nullable();
            $table->enum('display', ['Yes', 'No'])->default('Yes');
            $table->string('language_text', 50)->nullable();        $table->longText('title_languages')->nullable();   
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
        Schema::dropIfExists('support_languages');
    }
}
