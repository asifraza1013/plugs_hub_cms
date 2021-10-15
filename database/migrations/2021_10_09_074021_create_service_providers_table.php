<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_providers', function (Blueprint $table) {
            $table->id();
            $table->integer('user_apps_id')->index();
            $table->string('vendor_id')->unique();
            $table->string('country');
            $table->string('city');
            $table->string('address');
            $table->string('street');
            $table->string('post_code');
            $table->string('lat');
            $table->string('lng');
            $table->string('id_type')->nullable();
            $table->string('id_img_1')->nullable();
            $table->string('id_img_2')->nullable();
            $table->string('bill_img')->nullable();
            $table->string('parking_img')->nullable();
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
        Schema::dropIfExists('service_providers');
    }
}
