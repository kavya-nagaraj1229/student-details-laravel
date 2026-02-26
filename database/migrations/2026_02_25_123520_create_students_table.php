<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    Schema::create('students', function (Blueprint $table) {

        $table->id(); 
        $table->string('name'); 
        $table->string('lastname')->nullable();
        $table->string('fathername')->nullable();
        $table->string('mothername')->nullable();
        $table->date('dob')->nullable();
        $table->string('gender')->nullable();
        $table->string('maritalstatus')->nullable();
        $table->string('spouse')->nullable();
        $table->string('bloodgroup')->nullable();
        $table->string('education')->nullable();
        $table->string('email')->unique(); 
        $table->string('contact_number')->nullable();
        $table->string('aadhar')->nullable();
        $table->string('pan')->nullable();
        $table->integer('age');
        $table->string('license')->nullable();
        $table->string('pf_number')->nullable();
        $table->string('uan_number')->nullable();
        $table->string('esi_number')->nullable();
        $table->text('contact_address')->nullable();
        $table->string('contact_pincode')->nullable();
        $table->text('permanent_address')->nullable();
        $table->string('permanent_pincode')->nullable();
        $table->text('files')->nullable();

        // Marks system
        $table->json('marks')->nullable();
        $table->integer('total')->nullable();
        $table->float('average')->nullable();

        $table->timestamps();

    });
}

public function down()
{
    Schema::dropIfExists('students');
}

};