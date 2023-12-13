<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('user_courses', function (Blueprint $table) {
            $table->id();
            $table->string('user');
            $table->string('course');
            $table->string('status')->default('progress');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('user_courses');
    }
};
