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
        Schema::create('bloggers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fullName');
            $table->string('phoneNumber')->unique();
            $table->text('address')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('verifyToken')->nullable();
            $table->string('passResetToken')->nullable();
            $table->string('image')->default('public/uploads/avatar/avatar.png');
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('bloggers');
    }
};
