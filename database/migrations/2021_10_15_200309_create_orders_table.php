<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id')->index();
            $table->integer('provider_id')->index();
            $table->string('charging_time')->default(0);
            $table->string('plug_type')->nullable();
            $table->string('power')->nullable();
            $table->double('discount', 5,2)->default(0);
            $table->double('per_min_cost', 5,2)->default(0);
            $table->double('amount', 8,2)->nullable();
            $table->double('commission', 8,2)->default(0);
            $table->string('payment_method')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('comment')->nullable();
            $table->string('request_status')->default(1);
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
        Schema::dropIfExists('orders');
    }
}
