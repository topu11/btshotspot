<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('phone', 20);
            $table->integer('otp');
            $table->integer('isVerified')->default(0);
            $table->string('name',100)->nullable();
            $table->string('email',100)->nullable();
            $table->string('dob',10)->nullable();
            $table->string('photo',100)->nullable();
            $table->string('nidfpp',100)->nullable();
            $table->string('nidbpp',100)->nullable();
            $table->string('password',100)->nullable();
            $table->string('package',80)->nullable();
            $table->string('validity',5)->nullable();
            $table->string('price',10)->nullable();
            $table->string('fcmtoken',300)->nullable();
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
        Schema::dropIfExists('customers');
    }
}
