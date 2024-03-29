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
        // Schema::table('companies_gabs', function (Blueprint $table) {
        //     //
        // });

        Schema::table('companies', function (Blueprint $table) {
            $table->dropIndex(['name']);
            $table->dropIndex(['short_name']);
        });

        Schema::rename('companies', 'companies_gabs');

        Schema::table('companies_gabs', function (Blueprint $table) {
            $table->index(['name']);
            $table->index('short_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies_gabs', function (Blueprint $table) {
            //
        });
    }
};
