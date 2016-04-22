<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacebookUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facebook_users', function (Blueprint $table) {
            $table->string('id')->unique()->index();
            $table->string('token');
            $table->string('nickname');
            $table->string('name');
            $table->string('email');
            $table->string('avatar');
            $table->string('avatar_original');
            $table->string('gender');
            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->primary(['id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('facebook_users');
    }
}
