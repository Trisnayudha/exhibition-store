<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLevelToCompany extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('company', function (Blueprint $table) {
            $table->string('level')->nullable();
            $table->integer('promotional_access')->nullable();
            $table->integer('eventpass_access')->nullable();
            $table->integer('exhibition_access')->nullable();
            $table->integer('delegate_pass')->nullable();
            $table->integer('exhibitor_pass')->nullable();
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
