<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUpdateNullinCompaniesUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
          
            $table->string('designation')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('phone',20)->nullable()->change();
            $table->string('whatapp_no',20)->nullable()->change();
            $table->string('password')->nullable()->change();
            $table->text('admin_comment')->nullable()->change();
            $table->text('marketing_status')->nullable()->change();
            $table->text('marketing_memo_history')->nullable()->change();
            $table->string('register_on',50)->nullable()->change();
            $table->string('ip_address',100)->nullable()->change();
            $table->string('operating_system')->nullable()->change();
            $table->unsignedBigInteger('updated_by')->nullable()->change();
            $table->string('tax_id_no',100)->nullable()->change();
            $table->longText('business_type')->nullable()->change();
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
