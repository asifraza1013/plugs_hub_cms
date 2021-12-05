<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderHasStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_has_statuses', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders');

            $table->unsignedBigInteger('user_apps_id');
            // $table->foreign('user_apps_id')->references('id')->on('user_apps');

            $table->unsignedBigInteger('provider_id');
            // $table->foreign('provider_id')->references('id')->on('service_providers');

            $table->unsignedBigInteger('status_id');
            // $table->foreign('status_id')->references('id')->on('status');

            $table->string('comment')->nullable();
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
        Schema::dropIfExists('order_has_statuses');
    }
}
