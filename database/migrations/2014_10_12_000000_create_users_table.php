<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type')->default('viewer');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('source')->default('website');
            $table->string('otp')->nullable();
            $table->boolean('verified')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('last_login')->nullable();
            $table->rememberToken();
            $table->boolean('approved')->default(0);
            $table->string('status')->default('pending');
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
        Schema::dropIfExists('users');
    }
}
