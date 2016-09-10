<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_statuses', function (Blueprint $table) {

            $reflectionClass = new ReflectionClass(\App\Enums\UserStatus::class);
            $status = array_values($reflectionClass->getConstants());

            $table->increments('id');
            $table->string("label");
            $table->enum("code",$status);
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
        Schema::drop('user_statuses');
    }
}
