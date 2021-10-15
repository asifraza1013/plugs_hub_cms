<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChargerInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charger_infos', function (Blueprint $table) {
            $table->id();
            $table->integer('user_apps_id')->index();
            $table->string('charger_box');
            $table->string('charger_plug_type');
            $table->string('charger_level');
            $table->string('charger_capacity');
            $table->string('charger_voltage');
            $table->string('charger_img');
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
        Schema::dropIfExists('charger_infos');
    }
}
