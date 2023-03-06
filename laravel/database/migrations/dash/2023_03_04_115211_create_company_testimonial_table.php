<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_testimonial', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_user_id');
            $table->string('title',100)->nullable();
            $table->date('posted_date');
            $table->mediumText('description')->nullable();
            $table->string('person_name',100)->nullable();
            $table->string('email',100)->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->string('phone',15)->nullable();
            $table->string('image')->nullable();
            $table->integer('operator');
            $table->enum('testimonial_by',['Buyer','Dealer'])->default('Buyer');
            $table->boolean('show_person_name')->default('1');
            $table->string('jct_remark')->nullable();
            $table->boolean('show_jct_remark')->default('0');
            $table->unsignedBigInteger('testimonials_ref_id');
            $table->smallInteger('rating');
            $table->string('youtube_url');
            $table->string('image_url');
            $table->string('d_stock_number',50);
            $table->string('vehicle_image');
            $table->boolean('verified_buyer')->default('2');
            $table->boolean('is_paid')->default('1');
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
        Schema::dropIfExists('company_testimonial');
    }
};
