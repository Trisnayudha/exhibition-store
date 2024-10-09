<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMineexpoExhibitorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mineexpo_exhibitors', function (Blueprint $table) {
            $table->id();
            $table->integer('exhid')->nullable();
            $table->string('name')->nullable();
            $table->string('address')->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('website')->nullable();
            $table->text('description')->nullable();

            // Menggunakan JSON untuk menyimpan email dan kategori
            $table->json('emails')->nullable(); // Menyimpan hingga 3 email dalam JSON
            $table->json('categories')->nullable(); // Menyimpan hingga 10 kategori dalam JSON

            // Kolom string untuk media sosial
            $table->string('linkedin')->nullable();
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();

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
        Schema::dropIfExists('mineexpo_exhibitors');
    }
}
