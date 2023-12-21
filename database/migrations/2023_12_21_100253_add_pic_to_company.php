<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPicToCompany extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('company', function (Blueprint $table) {
            $table->integer('working_pass')->nullable();
            $table->integer('mining_pass')->nullable();
            $table->integer('exhibition_design')->nullable();
            $table->string('fascia_name')->nullable();
            $table->string('pic_name')->nullable();
            $table->string('pic_job_title')->nullable();
            $table->string('pic_email')->nullable();
            $table->string('pic_phone')->nullable();
            $table->string('pic_signature')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company', function (Blueprint $table) {
            //
        });
    }
}
