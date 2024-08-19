<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->id();

            $table->string('status')->default('pending');

            $table->unsignedInteger('user_id');
            $table->string('title');
            $table->string('ar_title')->nullable();

            $table->text('description')->nullable();
            $table->text('ar_description')->nullable();

            $table->string('phone')->nullable();
            $table->string('city')->nullable();

            $table->text('location')->nullable();
            $table->text('address')->nullable();


            $table->unsignedInteger('price')->nullable();
            $table->string('start_year')->nullable();
            $table->string('end_year')->nullable();
            $table->string('time')->nullable();

            $table->boolean('active')->default(1);
            $table->boolean('approved')->default(0);
            $table->boolean('deleted')->default(0);
            $table->boolean('removed')->default(0);

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
        Schema::dropIfExists('listings');
    }
}
