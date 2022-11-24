<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusColumnIntoAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('status')->default(\Appocean\Payment\Models\PaymentProcessStatus::PENDING);
        });

        Schema::table('plans', function (Blueprint $table) {
            $table->string('status')->default(\Appocean\Payment\Models\PaymentProcessStatus::PENDING);
        });

        Schema::table('plan_subscriptions', function (Blueprint $table) {
            $table->string('status')->default(\Appocean\Payment\Models\PaymentProcessStatus::PENDING);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('plan_subscriptions', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
