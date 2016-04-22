<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('location');
            $table->dateTime('startDateTime');
            $table->dateTime('endDateTime');
            $table->text('description');
            $table->string('pic');
            $table->boolean('isPublic');
            $table->integer('user_id')->unsigned();
            $table->timestamps();
        });

        Schema::create('event_user', function (Blueprint $table) {
            $table->integer('event_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();
            $table->primary(['event_id', 'user_id']);
            $table->string('status');
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
        Schema::drop('event_user');
        Schema::drop('events');
    }
}
