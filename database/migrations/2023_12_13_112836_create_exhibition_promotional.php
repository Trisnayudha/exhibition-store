<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExhibitionPromotional extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exhibition_promotional', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('company_id');
            $table->string('desc')->nullable();
            $table->string('file');
            $table->string('link');
            $table->string('type');
            $table->string('section');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exhibition_promotional');
    }
}
