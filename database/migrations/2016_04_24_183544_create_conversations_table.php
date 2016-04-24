<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConversationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
        });

        Schema::create('conversation_user', function (Blueprint $table) {
            $table->integer('conversation_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->primary(['conversation_id', 'user_id']);
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
        Schema::drop('conversation_user');
        Schema::drop('conversations');
    }
}
