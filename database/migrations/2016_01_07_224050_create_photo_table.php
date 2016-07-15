<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhotoTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('position')->nullable();
            $table->boolean('slider')->nullable();
            $table->string('filename', 255);
            $table->string('name', 255)->nullable();
            $table->text('description')->nullable();
            $table->string('file_size', 10)->nullable();
            $table->string('file_mine', 50)->nullable();
            $table->string('file_path')->nullable();
            $table->unsignedInteger('photo_album_id')->nullable();
            $table->foreign('photo_album_id')->references('id')->on('photo_albums')->onDelete('cascade');
            $table->boolean('album_cover')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger('user_id_edited')->nullable();
            $table->foreign('user_id_edited')->references('id')->on('users')->onDelete('cascade');
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
        Schema::drop('photos');
    }

}
