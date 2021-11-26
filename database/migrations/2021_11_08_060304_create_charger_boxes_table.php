<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChargerBoxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charger_boxes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type')->comment('1: BOX, 2: plug type')->default(1);
            $table->string('image')->nullable();
            $table->string('status')->default('Active');
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
        Schema::dropIfExists('charger_boxes');
    }
}
