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
        Schema::create('shippings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id');
            $table->string('fname');
            $table->string('lname');
            $table->string('companyname');
            $table->integer('country_id');
            $table->string('housenumber');
            $table->string('apartment')->nullable();
            $table->string('city');
            $table->string('state_id');
            $table->string('zipcode');
            $table->string('phone');
            $table->string('note')->nullable();
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
        Schema::dropIfExists('shippings');
    }
};
