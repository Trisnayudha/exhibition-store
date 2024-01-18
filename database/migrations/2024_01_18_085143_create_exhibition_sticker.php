<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExhibitionSticker extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exhibition_sticker', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('printing_position')->nullable();
            $table->string('section_sticker')->nullable();
            $table->string('file')->nullable();
            $table->string('note')->nullable();
            $table->string('company_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exhibition_sticker');
    }
}
