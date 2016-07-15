<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnlikeableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // this table will be morphy relation ship to other table like feed, comment, photo, etc.

        Schema::create('unlikeable', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // this will be anything, means it can be something like photo, comment, feed's id.
            $table->integer('unlikeable_id')->unsigned();
            // the likeable type references the models. ex. App\Models\photo
            $table->string('unlikeable_type');
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
        Schema::drop('unlikeable');
    }
}
