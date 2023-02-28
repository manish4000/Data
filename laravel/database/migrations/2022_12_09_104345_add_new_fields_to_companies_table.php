<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsToCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('company_name');
            $table->string('designation');
            $table->string('email');
            $table->string('phone',20);
            $table->string('whatapp_no',20);
            $table->string('password');//
            $table->text('admin_comment');
            $table->text('marketing_status');//
            $table->text('marketing_memo_history');//
            $table->string('register_on',50);
            $table->string('ip_address',100);
            $table->string('operating_system');
            $table->unsignedBigInteger('updated_by');//
            $table->string('tax_id_no',100);
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
