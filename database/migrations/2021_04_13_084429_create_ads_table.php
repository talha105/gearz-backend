<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('phone')->nullable();

            $table->text('location')->nullable();
            $table->string('address')->nullable();
            
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('make_id');
            $table->string('genre')->nullable();
            $table->unsignedInteger('modal_id');

            $table->text('attributes')->nullable();

            $table->string('day_price');
            $table->string('month_price')->nullable();
            $table->string('year_price')->nullable();

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
        Schema::dropIfExists('ads');
    }
}
