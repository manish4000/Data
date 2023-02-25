<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDealerPhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dealer_photos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('company_id')->index();
            $table->bigInteger('ref_id')->nullable()->index();
            $table->string('ref_model', 75)->nullable()->index();
            $table->string('file_category', 35)->nullable();
            $table->string('file_name', 255)->nullable();
            $table->string('file_size', 25)->nullable();
            $table->string('file_type', 75)->nullable();
            $table->string('file_extention', 10)->nullable();
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
        Schema::dropIfExists('dealer_photos');
    }
}
