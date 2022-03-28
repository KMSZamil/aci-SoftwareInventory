<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserManagerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('UserManager', function (Blueprint $table) {
            $table->id();
            $table->string('UserID',8)->unique();
            $table->string('UserName');
            $table->string('Designation')->nullable();
            $table->string('Email')->unique();
            $table->string('Password');
            $table->string('Active',1)->default('Y');
            $table->string('CreateBy')->nullable();
            $table->string('UpdateBy')->nullable();
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
        Schema::dropIfExists('UserManager');
    }
}
