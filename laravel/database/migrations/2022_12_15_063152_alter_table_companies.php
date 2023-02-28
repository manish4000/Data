<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableCompanies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
           // $table->dropColumn(['password','marketing_status','marketing_memo_history','updated_by']);
            $table->string('company_name',150)->nullable()->change();
            $table->uuid('uuid')->nullable()->change();
            $table->string('designation',200)->nullable()->change();
            $table->string('email',150)->nullable()->change();
            $table->string('operating_system',200)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            //
        });
    }
}
