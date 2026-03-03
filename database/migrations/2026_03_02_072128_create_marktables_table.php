<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('marktables', function (Blueprint $table) {

            $table->id();
            $table->string('name');
            $table->string('class');
            $table->string('session');
            $table->integer('age');
            $table->json('subjectsmark');
            $table->integer('total');
            $table->float('average');
            $table->text('images')->nullable();

        });
    }

    public function down()
    {
        Schema::dropIfExists('marktables');
    }
};