<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanySalesTeamSocialMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_sales_team_social_media', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_user_id')->nullable();
            $table->unsignedBigInteger('company_sales_team_id')->nullable();
            $table->unsignedBigInteger('social_media_id')->nullable();
            $table->string('value', 100)->nullable();
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
        Schema::dropIfExists('company_sales_team_social_media');
    }
}
