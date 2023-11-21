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
        Schema::create('couponcodes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('couponcode');
            $table->string('expairdate');
            $table->tinyInteger('offertype');
            $table->string('amount');
            $table->string('buyammount');
            $table->tinyInteger('status');

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
        Schema::dropIfExists('couponcodes');
    }
};
