<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacebookFeedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facebook_feeds', function (Blueprint $table) {
            $table->increments('id');
            $table->text('message');
            $table->string('message_id');
            $table->string('author_id');
            $table->integer('reply_to');
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
        Schema::drop('facebook_feeds');
    }
}
