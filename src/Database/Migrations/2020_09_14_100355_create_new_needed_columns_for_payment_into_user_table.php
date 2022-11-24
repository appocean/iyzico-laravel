<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewNeededColumnsForPaymentIntoUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('gsm_number')->nullable();
            $table->string('identity_number')->nullable();
            $table->string('city_name')->nullable();
            $table->string('country_name')->nullable();
            $table->string('address')->nullable();
            $table->string('zip_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('gsm_number');
            $table->dropColumn('identity_number');
            $table->dropColumn('city_name');
            $table->dropColumn('country_name');
            $table->dropColumn('address');
            $table->dropColumn('zip_code');
        });
    }
}
