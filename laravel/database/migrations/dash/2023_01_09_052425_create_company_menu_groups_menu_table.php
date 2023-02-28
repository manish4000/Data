<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyMenuGroupsMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_menu_groups_menu', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('parent_id', 11)->autoIncrement(false)->default(0);
            $table->unsignedInteger('order', 11)->autoIncrement(false)->default(0);
            $table->string('title', 50);
            $table->string('icon', 50)->nullable();
            $table->string('uri')->nullable();
            $table->unsignedInteger('company_menu_group_id')->nullable();
            $table->unsignedInteger('company_module_id')->nullable();
            $table->text('permissions')->nullable();
            $table->string('slug',100)->unique();
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
        Schema::dropIfExists('company_menu_groups_menu');
    }
}
