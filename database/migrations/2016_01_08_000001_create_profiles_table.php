<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('nickname')->unique();
            $table->string('first_name', 30);
            $table->string('last_name', 30);
            $table->unsignedInteger('gender_id')->nullable();
            $table->foreign('gender_id')->references('id')->on('genders')->onDelete('restrict')->onUpdate('restrict');
            $table->date('date_of_birth');
            $table->text('bio')->nullable();
            $table->unsignedInteger('avatar_photo_id')->nullable();
            $table->foreign('avatar_photo_id')->references('id')->on('photos');
            $table->unsignedInteger('cover_photo_id')->nullable();
            $table->foreign('cover_photo_id')->references('id')->on('photos');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('profiles');
    }

}
