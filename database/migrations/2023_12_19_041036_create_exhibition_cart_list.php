<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExhibitionCartList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exhibition_cart_list', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name_product')->nullable();
            $table->string('section_product')->nullable();
            $table->integer('price')->nullable();
            $table->integer('total_price')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('company_id')->nullable();
            $table->integer('payment_id')->nullable();
            $table->integer('delegate_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exhibition_cart_list');
    }
}
