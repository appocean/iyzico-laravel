<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaymentProvideReferenceKeyColumnIntoAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->string('payment_provider_reference_key')->nullable();
        });

        Schema::table('plan_subscriptions', function (Blueprint $table) {
            $table->string('payment_provider_reference_key')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn('payment_provider_reference_key');
        });

        Schema::table('plan_subscriptions', function (Blueprint $table) {
            $table->dropColumn('payment_provider_reference_key');
        });
    }
}
