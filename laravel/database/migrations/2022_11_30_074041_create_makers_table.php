<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMakersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('makers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique()->index();
            $table->bigInteger('parent_id')->nullable();
            $table->enum('display', ['Yes', 'No'])->default('Yes');
            $table->bigInteger('jct_ref_id')->nullable();
            $table->bigInteger('tcv_id')->nullable();
            $table->string('image')->nullable();
            
            $table->softDeletes();
            $table->timestamps();
            // $table->comment("0-jap 1-other Jap 2-Imported");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('makers');
    }
}
